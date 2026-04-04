<!-- bdm team -->
<div class="tab-pane fade rounded-4" id="teams" role="tabpanel">    
    <div>
        <?php
            $stmt2 = $conn -> prepare(" SELECT * FROM business_mentor WHERE reference_no = ? AND status = '1' ORDER BY business_mentor_id ASC");
            $stmt2 -> execute([$id]);
            $referrals2 = $stmt2->fetchAll(PDO::FETCH_ASSOC);
            if (!$referrals2) {
            ?>
            <button class="accordion p-0">
                <div class="card mb-0 rounded-0">
                    <div class="card-body p-2">
                        <div class="row align-items-center">
                            <h4>No Team found</h4>
                        </div>
                    </div>
                </div>
            </button>
            <?php
            }
            // print_r($stmt2);
            foreach($referrals2 as $referral2){
                $no_team=1;
                $bms_id = $referral2['business_mentor_id']; 
        ?>
        <button class="accordion p-0">
            <div class="card mb-0 rounded-0">
                <div class="card-body p-2">
                    <div class="row align-items-center">
                        <div class="col-lg-4 col-md-4 col-sm-12 col-12 py-2">
                            <div class="team-profile-img d-flex align-items-center justify-content-around">
                                <div class="avatar-md img-thumbnail rounded float-start rounded-circle">
                                    <img src="../../uploading/<?=$referral2['profile_pic']?>" alt="" class="img-fluid d-block rounded-circle" />
                                </div>
                                <div>
                                    <a href="#" class="d-block">
                                        <h5 class="fs-5 mb-1"><?=$referral2['firstname'].' '.$referral2['lastname'].' '.$bms_id?></h5>
                                    </a>
                                    <p class="text-muted mb-0">Business Mentor</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-12 col-12 py-2">
                            <div class="row text-center">
                                <div class="col-6 border-end">
                                    <?php
                                        $countQuery1 = "SELECT 
                                                        (
                                                            SELECT COUNT(ca_travelagency_id) 
                                                            FROM ca_travelagency 
                                                            WHERE 
                                                                reference_no = :bms_id 
                                                                AND status = 1 
                                                                AND ca_travelagency_id IS NOT NULL 
                                                                AND ca_travelagency_id != ''
                                                        ) AS tacount,
                                                        (
                                                            SELECT COUNT(corporate_agency_id) 
                                                            FROM corporate_agency 
                                                            WHERE 
                                                                reference_no = :bms_id 
                                                                AND status = 1 
                                                                AND corporate_agency_id IS NOT NULL 
                                                                AND corporate_agency_id != ''
                                                        ) AS cacount";

                                        //$debugQuery = str_replace(':bdms_id', $bdms_id, $countQuery);
                                        //echo "<pre>Debug SQL:\n$debugQuery</pre>";  
                                        $stmt1_1 = $conn->prepare($countQuery1);
                                        $stmt1_1->bindParam(':bms_id', $bms_id, PDO::PARAM_STR);
                                        $stmt1_1->execute();
                                        
                                        if ($stmt1_1->rowCount() > 0) {
                                            $results1_1 = $stmt1_1->fetchAll(PDO::FETCH_ASSOC);
                                            //print_r($results1_1); // ✅ This will show the actual result array

                                            foreach ($results1_1 as $row) {
                                                $TACount = (int)$row['tacount'];
                                                $CACount = (int)$row['cacount'];
                                                $total_bm_mem = $TACount + $CACount; 
                                                // echo "<script>
                                                //         console.log('total bm mem count:".$total_bm_mem." of ".$bms_id."');
                                                //     </script>";
                                    
                                    ?>
                                    <h5 class="mb-1"><?=$total_bm_mem?></h5>
                                    <?php
                                            }
                                        }
                                    ?>
                                    <p class="text-muted mb-0">Total Team Member</p>
                                </div>
                                <div class="col-6">
                                    <?php
                                        $countPAC1 = "SELECT COUNT(bdm_id) AS PECcount FROM product_payout WHERE bm_id='".$bms_id."' ";
                                        $pecCount1 = $conn -> prepare($countPAC1);
                                        $pecCount1 -> execute();
                                        $pecCount1 -> setFetchMode(PDO::FETCH_ASSOC);
                                        if( $pecCount1 -> rowCount()>0 ){
                                            foreach( ($pecCount1 -> fetchAll()) as $keyPec => $rowPec ){
                                                $PecCount1 = $rowPec['PECcount'];
                                    ?>
                                    <h5 class="mb-1"><?=$PecCount1?></h5>
                                    <?php
                                            }
                                        }
                                    ?>
                                    <p class="text-muted mb-0">Total Packages</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-2 col-sm-6 col-6 py-2">
                            <h5 class="mb-1"><?=$referral2['contact_no']?></h5>
                            <p class="text-muted mb-0">Phone No</p>
                        </div>
                        <div class="col-lg-2 col-md-2 col-sm-6 col-6 py-2">
                            <div class="text-center">
                                <a href="#" onclick="overviewPage('<?= $referral2['business_mentor_id'] .  $referral2['reference_no'] . ',' .$referral2['country']. ',' .$referral2['state']. ',' .$referral2['city']. ',business_mentor' ?>')" class="btn btn-primary view-btn">View Profile</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </button>
        <!-- all TE under given BM -->
        <div class="panel">
            <?php
                $stmt2_3 = $conn -> prepare(" SELECT * FROM corporate_agency WHERE reference_no = ? AND status = '1' ORDER BY corporate_agency_id ASC");
                $stmt2_3 -> execute([$bms_id]);
                $referrals2_3 = $stmt2_3->fetchAll(PDO::FETCH_ASSOC);
                $no_team=0;
                foreach($referrals2_3 as $referral2){
                    $no_team=1;
                    $cas_id = $referral2['corporate_agency_id'];
            ?>
            <button class="accordion p-0">
                <div class="card mb-0 rounded-0">
                    <div class="card-body p-2">
                        <div class="row align-items-center">
                            <div class="col-lg-4 col-md-4 col-sm-12 col-12 py-2">
                                <div class="team-profile-img d-flex align-items-center justify-content-around">
                                    <div class="avatar-md img-thumbnail rounded float-start rounded-circle">
                                        <img src="../../uploading/<?=$referral2['profile_pic']?>" alt="" class="img-fluid d-block rounded-circle" />
                                    </div>
                                    <div>
                                        <a href="#" class="d-block">
                                            <h5 class="fs-5 mb-1"><?=$referral2['firstname'].' '.$referral2['lastname'].' '.$cas_id?></h5>
                                        </a>
                                        <p class="text-muted mb-0">Techno Enterprise</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-12 col-12 py-2">
                                <div class="row text-center">
                                    <div class="col-6 border-end">
                                        <?php
                                            $countCATA2_3 = "SELECT COUNT(ca_travelagency_id) AS CATAcount FROM ca_travelagency WHERE reference_no='".$cas_id."' ";
                                            $cataCount2_3 = $conn -> prepare($countCATA2_3);
                                            $cataCount2_3 -> execute();
                                            $cataCount2_3 -> setFetchMode(PDO::FETCH_ASSOC);
                                            if( $cataCount2_3 -> rowCount()>0 ){
                                                foreach( ($cataCount2_3 -> fetchAll()) as $keyCATA => $rowCATA ){
                                                    $CATACount3 = $rowCATA['CATAcount']; 
                                        ?>
                                        <h5 class="mb-1"><?=$CATACount3?></h5>
                                        <?php
                                                }
                                            }
                                        ?>
                                        <p class="text-muted mb-0">Total Team Member</p>
                                    </div>
                                    <div class="col-6">
                                        <?php
                                            $countPAC2_3 = "SELECT COUNT(te_id) AS PECcount FROM product_payout WHERE te_id='".$cas_id."' ";
                                            $pecCount2_3 = $conn -> prepare($countPAC2_3);
                                            $pecCount2_3 -> execute();
                                            $pecCount2_3 -> setFetchMode(PDO::FETCH_ASSOC);
                                            if( $pecCount2_3 -> rowCount()>0 ){
                                                foreach( ($pecCount2_3 -> fetchAll()) as $keyPec => $rowPec ){
                                                    $PecCount2_3 = $rowPec['PECcount'];
                                        ?>
                                        <h5 class="mb-1"><?=$PecCount2_3?></h5>
                                        <?php
                                                }
                                            }
                                        ?>
                                        <p class="text-muted mb-0">Total Packages</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-2 col-md-2 col-sm-6 col-6 py-2">
                                <h5 class="mb-1"><?=$referral2['contact_no']?></h5>
                                <p class="text-muted mb-0">Phone No</p>
                            </div>
                            <div class="col-lg-2 col-md-2 col-sm-6 col-6 py-2">
                                <div class="text-center">
                                    <a href="#" onclick="overviewPage('<?= $referral2['corporate_agency_id'] .','.  $referral2['reference_no'] . ',' .$referral2['country']. ',' .$referral2['state']. ',' .$referral2['city']. ',corporate_agency' ?>')" class="btn btn-primary view-btn">View Profile</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </button>
            <!-- all TC recruted by TE -->
            <div class="panel">
                <?php
                    $stmt3 = $conn -> prepare(" SELECT * FROM ca_travelagency WHERE reference_no = ? AND status = '1' ORDER BY ca_travelagency_id ASC");
                    $stmt3 -> execute([$cas_id]);
                    $referrals3 = $stmt3->fetchAll(PDO::FETCH_ASSOC);
                    $no_team=0;
                    foreach($referrals3 as $referral3){
                        $no_team=1;
                        $catas_id = $referral3['ca_travelagency_id'];
                ?>
                <button class="accordion p-0">
                    <div class="card mb-0 rounded-0">
                        <div class="card-body p-2">
                            <div class="row align-items-center">
                                <div class="col-lg-4 col-md-4 col-sm-12 col-12 py-2">
                                    <div class="team-profile-img d-flex align-items-center justify-content-around">
                                        <div class="avatar-md img-thumbnail rounded float-start rounded-circle">
                                            <img src="../../uploading/<?=$referral3['profile_pic']?>" alt="" class="img-fluid d-block rounded-circle" />
                                        </div>
                                        <div>
                                            <a href="#" class="d-block">
                                                <h5 class="fs-5 mb-1"><?=$referral3['firstname'].' '.$referral3['lastname'].' '.$catas_id?></h5>
                                            </a>
                                            <p class="text-muted mb-0">Travel Consultant</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-12 col-12 py-2">
                                    <div class="row text-center">
                                        <div class="col-6 border-end">
                                            <?php
                                                $countCACU = "SELECT COUNT(ca_customer_id) AS CACUcount FROM ca_customer WHERE ta_reference_no='".$catas_id."' ";
                                                $cacuCount = $conn -> prepare($countCACU);
                                                $cacuCount -> execute();
                                                $cacuCount -> setFetchMode(PDO::FETCH_ASSOC);
                                                if( $cacuCount -> rowCount()>0 ){
                                                    foreach( ($cacuCount -> fetchAll()) as $keyCACU => $rowCACU ){
                                                        $CACUCount = $rowCACU['CACUcount'];
                                            ?>
                                            <h5 class="mb-1"><?= $CACUCount ?></h5>
                                            <?php
                                                    }
                                                }
                                            ?>
                                            <p class="text-muted mb-0">Total Team Member</p>
                                        </div>
                                        <div class="col-6">
                                            <?php
                                                $countPAC = "SELECT COUNT(ta_id) AS PECcount FROM product_payout WHERE ta_id='".$catas_id."' ";
                                                $pecCount = $conn -> prepare($countPAC);
                                                $pecCount -> execute();
                                                $pecCount -> setFetchMode(PDO::FETCH_ASSOC);
                                                if( $pecCount -> rowCount()>0 ){
                                                    foreach( ($pecCount -> fetchAll()) as $keyPec => $rowPec ){
                                                        $PecCount = $rowPec['PECcount'];
                                            ?>
                                            <h5 class="mb-1"><?=$PecCount?></h5>
                                            <?php
                                                    }
                                                }
                                            ?>
                                            <p class="text-muted mb-0">Total Packages</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-2 col-sm-6 col-6 py-2">
                                    <h5 class="mb-1"><?php $referral3['contact_no'] ?></h5>
                                    <p class="text-muted mb-0">Phone No</p>
                                </div>
                                <div class="col-lg-2 col-md-2 col-sm-6 col-6 py-2">
                                    <div class="text-center">
                                        <a href="#" onclick="overviewPage('<?= $referral3['ca_travelagency_id'] .','.  $referral3['reference_no'] . ',' .$referral3['country']. ',' .$referral3['state']. ',' .$referral3['city']. ',travel_consultant' ?>')" class="btn btn-primary view-btn">View Profile</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </button>
                <!-- all Customers onboarded by TC -->
                <div class="panel">
                    <?php
                        $stmt4 = $conn -> prepare(" SELECT * FROM ca_customer WHERE ta_reference_no = ? AND reference_no IS NUll AND status = '1' ORDER BY ca_customer_id ASC");
                        $stmt4 -> execute([$catas_id]);
                        $referrals4 = $stmt4->fetchAll(PDO::FETCH_ASSOC);
                        $no_team=0;
                        foreach($referrals4 as $referral4){
                            $no_team=1;
                            $cacus_id = $referral4['ca_customer_id'];
                    ?>
                    <button class="accordion p-0">
                        <div class="card mb-0 rounded-0">
                            <div class="card-body p-2">
                                <div class="row align-items-center">
                                    <div class="col-lg-4 col-md-4 col-sm-12 col-12 py-2">
                                        <div class="team-profile-img d-flex align-items-center justify-content-around">
                                            <div class="avatar-md img-thumbnail rounded float-start rounded-circle">
                                                <img src="../../uploading/<?=$referral4['profile_pic']?>" alt="" class="img-fluid d-block rounded-circle" />
                                            </div>
                                            <div>
                                                <a href="#" class="d-block">
                                                    <h5 class="fs-5 mb-1"><?=$referral4['firstname'].' '.$referral4['lastname'].' '.$cacus_id?></h5>
                                                </a>
                                                <p class="text-muted mb-0">Customer</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-sm-12 col-12 py-2">
                                        <div class="row text-center">
                                            <div class="col-6 border-end">
                                                <?php
                                                    $countCATACU = "SELECT COUNT(ca_customer_id) AS CATACUcount FROM ca_customer WHERE reference_no='".$cacus_id."' ";
                                                    $catacuCount = $conn -> prepare($countCATACU);
                                                    $catacuCount -> execute();
                                                    $catacuCount -> setFetchMode(PDO::FETCH_ASSOC);
                                                    if( $catacuCount -> rowCount()>0 ){
                                                        foreach( ($catacuCount -> fetchAll()) as $keyCATACU => $rowCATACU ){
                                                            $CATACUCount = $rowCATACU['CATACUcount'];
                                                ?>
                                                <h5 class="mb-1"><?=$CATACUCount?></h5>
                                                <?php
                                                        }
                                                    }
                                                ?>
                                                <p class="text-muted mb-0">Total Refered Customers</p>
                                            </div>
                                            <div class="col-6">
                                                <?php
                                                    $countPAC = "SELECT COUNT(cu_id) AS PECcount FROM product_payout WHERE cu_id='".$cacus_id."' ";
                                                    $pecCount = $conn -> prepare($countPAC);
                                                    $pecCount -> execute();
                                                    $pecCount -> setFetchMode(PDO::FETCH_ASSOC);
                                                    if( $pecCount -> rowCount()>0 ){
                                                        foreach( ($pecCount -> fetchAll()) as $keyPec => $rowPec ){
                                                            $PecCount = $rowPec['PECcount'];
                                                ?>
                                                <h5 class="mb-1"><?=$PecCount?></h5>
                                                <?php
                                                        }
                                                    }
                                                ?>
                                                <p class="text-muted mb-0">Total Packages</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-2 col-md-2 col-sm-6 col-6 py-2">
                                        <h5 class="mb-1"><?=$referral4['contact_no']?></h5>
                                        <p class="text-muted mb-0">Phone No</p>
                                    </div>
                                    <div class="col-lg-2 col-md-2 col-sm-6 col-6 py-2">
                                        <div class="text-center">
                                            <a href="#" onclick="overviewPage('<?= $referral4['ca_customer_id'] .','.  $referral4['reference_no'] . ',' .$referral4['country']. ',' .$referral4['state']. ',' .$referral4['city']. ',customer' ?>')" class="btn btn-primary view-btn">View Profile</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </button>
                    <!-- customer ref level 1 -->
                    <div class="panel">
                        <?php
                            $stmt5 = $conn -> prepare(" SELECT * FROM ca_customer WHERE reference_no = ? AND status = '1' ORDER BY ca_customer_id ASC");
                            $stmt5 -> execute([$cacus_id]);
                            $referrals5 = $stmt5->fetchAll(PDO::FETCH_ASSOC);
                            $no_team=0;
                            foreach($referrals5 as $referral5){
                                $no_team=1;
                                $customer_id = $referral5['ca_customer_id'];
                        ?>
                        <button class="accordion p-0">
                            <div class="card mb-0 rounded-0">
                                <div class="card-body p-2">
                                    <div class="row align-items-center">
                                        <div class="col-lg-4 col-md-4 col-sm-12 col-12 py-2">
                                            <div class="team-profile-img d-flex align-items-center justify-content-around">
                                                <div class="avatar-md img-thumbnail rounded float-start rounded-circle">
                                                    <img src="../../uploading/<<?=$referral5['profile_pic']?>" alt="" class="img-fluid d-block rounded-circle" />
                                                </div>
                                                <div>
                                                    <a href="#" class="d-block">
                                                        <h5 class="fs-5 mb-1"><?=$referral5['firstname'].' '.$referral5['lastname'].' '.$customer_id?></h5>
                                                    </a>
                                                    <p class="text-muted mb-0">Customer</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-md-4 col-sm-12 col-12 py-2">
                                            <div class="row text-center">
                                                <div class="col-6 border-end">
                                                    <?php
                                                        $countCU = "SELECT COUNT(ca_customer_id) AS CATAcount FROM ca_customer WHERE reference_no='".$customer_id."' ";
                                                        $cuCount = $conn -> prepare($countCU);
                                                        $cuCount -> execute();
                                                        $cuCount -> setFetchMode(PDO::FETCH_ASSOC);
                                                        if( $cuCount -> rowCount()>0 ){
                                                            foreach( ($cuCount -> fetchAll()) as $keycu => $rowcu ){
                                                                $cuCount = $rowcu['CATAcount'];
                                                    ?>
                                                    <h5 class="mb-1"><?=$cuCount?></h5>
                                                    <?php
                                                            }
                                                        }
                                                    ?>
                                                    <p class="text-muted mb-0">Total Refered Customers</p>
                                                </div>
                                                <div class="col-6">
                                                    <?php
                                                        $countPAC = "SELECT COUNT(cu_id) AS PECcount FROM product_payout WHERE cu_id='".$customer_id."' ";
                                                        $pecCount = $conn -> prepare($countPAC);
                                                        $pecCount -> execute();
                                                        $pecCount -> setFetchMode(PDO::FETCH_ASSOC);
                                                        if( $pecCount -> rowCount()>0 ){
                                                            foreach( ($pecCount -> fetchAll()) as $keyPec => $rowPec ){
                                                                $PecCount = $rowPec['PECcount'];
                                                    ?>
                                                    <h5 class="mb-1">20</h5>
                                                    <?php
                                                            }
                                                        }
                                                    ?>
                                                    <p class="text-muted mb-0">Total Packages</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-2 col-md-2 col-sm-6 col-6 py-2">
                                            <h5 class="mb-1"><?=$referral5['contact_no']?></h5>
                                            <p class="text-muted mb-0">Phone No</p>
                                        </div>
                                        <div class="col-lg-2 col-md-2 col-sm-6 col-6 py-2">
                                            <div class="text-center">
                                                <a href="#" onclick="overviewPage('<?= $referral5['ca_customer_id'] .','.  $referral5['reference_no'] . ',' .$referral5['country']. ',' .$referral5['state']. ',' .$referral5['city']. ',customer' ?>')" class="btn btn-primary view-btn">View Profile</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </button>
                        <!-- cumtomer ref level 2 -->
                        <div class="panel">
                            <?php
                                $stmt6 = $conn -> prepare(" SELECT * FROM ca_customer WHERE reference_no = ? AND status = '1' ORDER BY ca_customer_id ASC");
                                $stmt6 -> execute([$customer_id]);
                                $referrals6 = $stmt6->fetchAll(PDO::FETCH_ASSOC);
                                $no_team=0;
                                foreach($referrals6 as $referral6){
                                    $no_team=1;
                                    $customer_id2 = $referral6['ca_customer_id'];
                            ?>
                            <button class="accordion p-0">
                                <div class="card mb-0 rounded-0">
                                    <div class="card-body p-2">
                                        <div class="row align-items-center">
                                            <div class="col-lg-4 col-md-4 col-sm-12 col-12 py-2">
                                                <div class="team-profile-img d-flex align-items-center justify-content-around">
                                                    <div class="avatar-md img-thumbnail rounded float-start rounded-circle">
                                                        <img src="../../uploading/<?=$referral6['profile_pic']?>" alt="" class="img-fluid d-block rounded-circle" />
                                                    </div>
                                                    <div>
                                                        <a href="#" class="d-block">
                                                            <h5 class="fs-5 mb-1"><?=$referral6['firstname'].' '.$referral6['lastname'].' '.$customer_id2?></h5>
                                                        </a>
                                                        <p class="text-muted mb-0">Customer</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-md-4 col-sm-12 col-12 py-2">
                                                <div class="row text-center">
                                                    <div class="col-6 border-end">
                                                        <?php
                                                            $countCU2 = "SELECT COUNT(ca_customer_id) AS CATAcount FROM ca_customer WHERE reference_no='".$customer_id2."' ";
                                                            $cuCount2 = $conn -> prepare($countCU2);
                                                            $cuCount2 -> execute();
                                                            $cuCount2 -> setFetchMode(PDO::FETCH_ASSOC);
                                                            if( $cuCount2 -> rowCount()>0 ){
                                                                foreach( ($cuCount2 -> fetchAll()) as $keycu2 => $rowcu2 ){
                                                                    $cu2Count = $rowcu2['CATAcount'];
                                                        ?>
                                                        <h5 class="mb-1"><?= $cu2Count?></h5>
                                                        <?php
                                                                }
                                                            }
                                                        ?>
                                                        <p class="text-muted mb-0">Total Refered Customers</p>
                                                    </div>
                                                    <div class="col-6">
                                                        <?php
                                                            $countPAC2 = "SELECT COUNT(cu_id) AS PECcount FROM product_payout WHERE cu_id='".$customer_id2."' ";
                                                            $pecCount2 = $conn -> prepare($countPAC2);
                                                            $pecCount2 -> execute();
                                                            $pecCount2 -> setFetchMode(PDO::FETCH_ASSOC);
                                                            if( $pecCount2 -> rowCount()>0 ){
                                                                foreach( ($pecCount2 -> fetchAll()) as $keyPec2 => $rowPec2 ){
                                                                    $PecCount2 = $rowPec2['PECcount'];
                                                        ?>
                                                        <h5 class="mb-1"><?=$PecCount2?></h5>
                                                        <?php
                                                                }
                                                            }
                                                        ?>
                                                        <p class="text-muted mb-0">Total Packages</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-2 col-md-2 col-sm-6 col-6 py-2">
                                                <h5 class="mb-1"><?=$referral6['contact_no']?></h5>
                                                <p class="text-muted mb-0">Phone No</p>
                                            </div>
                                            <div class="col-lg-2 col-md-2 col-sm-6 col-6 py-2">
                                                <div class="text-center">
                                                    <a href="#" onclick="overviewPage('<?= $referral6['ca_customer_id'] .','.  $referral6['reference_no'] . ',' .$referral6['country']. ',' .$referral6['state']. ',' .$referral6['city']. ',customer' ?>')" class="btn btn-primary view-btn">View Profile</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </button>
                            <!-- cumtomer ref level 3 -->
                            <div class="panel">
                                <?php
                                    $stmt6 = $conn -> prepare(" SELECT * FROM ca_customer WHERE reference_no = ? AND status = '1' ORDER BY ca_customer_id ASC");
                                    $stmt6 -> execute([$customer_id2]);
                                    $referrals6 = $stmt6->fetchAll(PDO::FETCH_ASSOC);
                                    $no_team=0;
                                    foreach($referrals6 as $referral6){
                                        $no_team=1;
                                        $customer_id3 = $referral6['ca_customer_id'];
                                ?>
                                <button class="accordion p-0">
                                    <div class="card mb-0 rounded-0">
                                        <div class="card-body p-2">
                                            <div class="row align-items-center">
                                                <div class="col-lg-4 col-md-4 col-sm-12 col-12 py-2">
                                                    <div class="team-profile-img d-flex align-items-center justify-content-around">
                                                        <div class="avatar-md img-thumbnail rounded float-start rounded-circle">
                                                            <img src="../../uploading/<?=$referral6['profile_pic']?>" alt="" class="img-fluid d-block rounded-circle" />
                                                        </div>
                                                        <div>
                                                            <a href="#" class="d-block">
                                                                <h5 class="fs-5 mb-1"><?=$referral6['firstname'].' '.$referral6['lastname'].' '.$customer_id3?></h5>
                                                            </a>
                                                            <p class="text-muted mb-0">Customer</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4 col-md-4 col-sm-12 col-12 py-2">
                                                    <div class="row text-center">
                                                        <div class="col-6 border-end">
                                                            <?php
                                                                $countCU2 = "SELECT COUNT(ca_customer_id) AS CATAcount FROM ca_customer WHERE reference_no='".$customer_id3."' ";
                                                                $cuCount2 = $conn -> prepare($countCU2);
                                                                $cuCount2 -> execute();
                                                                $cuCount2 -> setFetchMode(PDO::FETCH_ASSOC);
                                                                if( $cuCount2 -> rowCount()>0 ){
                                                                    foreach( ($cuCount2 -> fetchAll()) as $keycu2 => $rowcu2 ){
                                                                        $cu2Count = $rowcu2['CATAcount'];
                                                            ?>
                                                            <h5 class="mb-1"><?=$cu2Count?></h5>
                                                            <?php
                                                                    }
                                                                }
                                                            ?>
                                                            <p class="text-muted mb-0">Total Refered Customers</p>
                                                        </div>
                                                        <div class="col-6">
                                                            <?php
                                                                $countPAC2 = "SELECT COUNT(cu_id) AS PECcount FROM product_payout WHERE cu_id='".$customer_id3."' ";
                                                                $pecCount2 = $conn -> prepare($countPAC2);
                                                                $pecCount2 -> execute();
                                                                $pecCount2 -> setFetchMode(PDO::FETCH_ASSOC);
                                                                if( $pecCount2 -> rowCount()>0 ){
                                                                    foreach( ($pecCount2 -> fetchAll()) as $keyPec2 => $rowPec2 ){
                                                                        $PecCount2 = $rowPec2['PECcount'];
                                                            ?>
                                                            <h5 class="mb-1"><?=$PecCount2?></h5>
                                                            <?php
                                                                    }
                                                                }
                                                            ?>
                                                            <p class="text-muted mb-0">Total Packages</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-2 col-md-2 col-sm-6 col-6 py-2">
                                                    <h5 class="mb-1"><?=$referral6['contact_no']?></h5>
                                                    <p class="text-muted mb-0">Phone No</p>
                                                </div>
                                                <div class="col-lg-2 col-md-2 col-sm-6 col-6 py-2">
                                                    <div class="text-center">
                                                        <a href="#" onclick="overviewPage('<?= $referral6['ca_customer_id'] .','.  $referral6['reference_no'] . ',' .$referral6['country']. ',' .$referral6['state']. ',' .$referral6['city']. ',customer' ?>')" class="btn btn-primary view-btn">View Profile</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </button>
                                <?php
                                    }
                                ?>
                            </div>
                            <?php
                                }
                            ?>
                            <!-- end cumtomer ref level 3 -->
                        </div>
                        <!-- end cumtomer ref level 2 -->
                        <?php
                            }
                        ?>
                    </div>
                    <!-- end customer ref level 1 -->
                    <?php
                        }
                    ?>
                </div>
                <!-- end all Customers onboarded by TC -->
                <?php
                    }
                ?>
            </div>
            <!-- end all TC recruted by TE -->
            <?php
                }
            ?>
            <!-- TC recruted by BM -->
            <?php
                $stmt2_3 = $conn -> prepare(" SELECT * FROM ca_travelagency WHERE reference_no = ? AND status = '1' ORDER BY ca_travelagency_id ASC");
                $stmt2_3 -> execute([$bms_id]);
                $referrals2_3 = $stmt2_3->fetchAll(PDO::FETCH_ASSOC);
                $no_team=0;
                foreach($referrals2_3 as $referral2){
                    $no_team=1;
                    $cas_id = $referral2['ca_travelagency_id'];
            ?>
            <button class="accordion p-0">
                <div class="card mb-0 rounded-0">
                    <div class="card-body p-2">
                        <div class="row align-items-center">
                            <div class="col-lg-4 col-md-4 col-sm-12 col-12 py-2">
                                <div class="team-profile-img d-flex align-items-center justify-content-around">
                                    <div class="avatar-md img-thumbnail rounded float-start rounded-circle">
                                        <img src="../../uploading/<?=$referral2['profile_pic']?>" alt="" class="img-fluid d-block rounded-circle" />
                                    </div>
                                    <div>
                                        <a href="#" class="d-block">
                                            <h5 class="fs-5 mb-1"><?=$referral2['firstname'].' '.$referral2['lastname'].' '.$cas_id?></h5>
                                        </a>
                                        <p class="text-muted mb-0">Travel Consultant</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-12 col-12 py-2">
                                <div class="row text-center">
                                    <div class="col-6 border-end">
                                        <?php
                                            $countCACU2 = "SELECT COUNT(ca_customer_id) AS CACUcount FROM ca_customer WHERE ta_reference_no='".$cas_id."' ";
                                            $cacuCount2 = $conn -> prepare($countCACU2);
                                            $cacuCount2 -> execute();
                                            $cacuCount2 -> setFetchMode(PDO::FETCH_ASSOC);
                                            if( $cacuCount2 -> rowCount()>0 ){
                                                foreach( ($cacuCount2 -> fetchAll()) as $keyCACU => $rowCACU ){
                                                    $CACUCount2 = $rowCACU['CACUcount'];
                                        ?>
                                        <h5 class="mb-1"><?=$CACUCount2?></h5>
                                        <?php
                                                }
                                            }
                                        ?>
                                        <p class="text-muted mb-0">Total Team Member</p>
                                    </div>
                                    <div class="col-6">
                                        <?php
                                            $countPAC3 = "SELECT COUNT(ta_id) AS PECcount FROM product_payout WHERE ta_id='".$cas_id."' ";
                                            $pecCount3 = $conn -> prepare($countPAC3);
                                            $pecCount3 -> execute();
                                            $pecCount3 -> setFetchMode(PDO::FETCH_ASSOC);
                                            if( $pecCount3 -> rowCount()>0 ){
                                                foreach( ($pecCount3 -> fetchAll()) as $keyPec => $rowPec ){
                                                    $PecCount3 = $rowPec['PECcount'];
                                        ?>
                                        <h5 class="mb-1"><?=$PecCount3?></h5>
                                        <?php
                                                }
                                            }
                                        ?>
                                        <p class="text-muted mb-0">Total Packages</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-2 col-md-2 col-sm-6 col-6 py-2">
                                <h5 class="mb-1"><?=$referral2['contact_no']?></h5>
                                <p class="text-muted mb-0">Phone No</p>
                            </div>
                            <div class="col-lg-2 col-md-2 col-sm-6 col-6 py-2">
                                <div class="text-center">
                                    <a href="#" onclick="overviewPage('<?= $referral2['ca_travelagency_id'] .','.  $referral2['reference_no'] . ',' .$referral2['country']. ',' .$referral2['state']. ',' .$referral2['city']. ',travel_consultant' ?>')" class="btn btn-primary view-btn">View Profile</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </button>
            <!-- all Customers onboarded by TC -->
                <div class="panel">
                    <?php
                        $stmt4 = $conn -> prepare(" SELECT * FROM ca_customer WHERE ta_reference_no = ? AND reference_no IS NUll AND status = '1' ORDER BY ca_customer_id ASC");
                        $stmt4 -> execute([$cas_id]);
                        $referrals4 = $stmt4->fetchAll(PDO::FETCH_ASSOC);
                        $no_team=0;
                        foreach($referrals4 as $referral4){
                            $no_team=1;
                            $cacus_id = $referral4['ca_customer_id'];
                    ?>
                    <button class="accordion p-0">
                        <div class="card mb-0 rounded-0">
                            <div class="card-body p-2">
                                <div class="row align-items-center">
                                    <div class="col-lg-4 col-md-4 col-sm-12 col-12 py-2">
                                        <div class="team-profile-img d-flex align-items-center justify-content-around">
                                            <div class="avatar-md img-thumbnail rounded float-start rounded-circle">
                                                <img src="../../uploading/<?=$referral4['profile_pic']?>" alt="" class="img-fluid d-block rounded-circle" />
                                            </div>
                                            <div>
                                                <a href="#" class="d-block">
                                                    <h5 class="fs-5 mb-1"><?=$referral4['firstname'].' '.$referral4['lastname'].' '.$cacus_id?></h5>
                                                </a>
                                                <p class="text-muted mb-0">Customer</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-sm-12 col-12 py-2">
                                        <div class="row text-center">
                                            <div class="col-6 border-end">
                                                <?php
                                                    $countCATACU = "SELECT COUNT(ca_customer_id) AS CATACUcount FROM ca_customer WHERE reference_no='".$cacus_id."' ";
                                                    $catacuCount = $conn -> prepare($countCATACU);
                                                    $catacuCount -> execute();
                                                    $catacuCount -> setFetchMode(PDO::FETCH_ASSOC);
                                                    if( $catacuCount -> rowCount()>0 ){
                                                        foreach( ($catacuCount -> fetchAll()) as $keyCATACU => $rowCATACU ){
                                                            $CATACUCount = $rowCATACU['CATACUcount'];
                                                ?>
                                                <h5 class="mb-1"><?=$CATACUCount?></h5>
                                                <?php
                                                        }
                                                    }
                                                ?>
                                                <p class="text-muted mb-0">Total Refered Customers</p>
                                            </div>
                                            <div class="col-6">
                                                <?php
                                                    $countPAC = "SELECT COUNT(cu_id) AS PECcount FROM product_payout WHERE cu_id='".$cacus_id."' ";
                                                    $pecCount = $conn -> prepare($countPAC);
                                                    $pecCount -> execute();
                                                    $pecCount -> setFetchMode(PDO::FETCH_ASSOC);
                                                    if( $pecCount -> rowCount()>0 ){
                                                        foreach( ($pecCount -> fetchAll()) as $keyPec => $rowPec ){
                                                            $PecCount = $rowPec['PECcount'];
                                                ?>
                                                <h5 class="mb-1"><?=$PecCount?></h5>
                                                <?php
                                                        }
                                                    }
                                                ?>
                                                <p class="text-muted mb-0">Total Packages</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-2 col-md-2 col-sm-6 col-6 py-2">
                                        <h5 class="mb-1"><?=$referral4['contact_no']?></h5>
                                        <p class="text-muted mb-0">Phone No</p>
                                    </div>
                                    <div class="col-lg-2 col-md-2 col-sm-6 col-6 py-2">
                                        <div class="text-center">
                                            <a href="#" onclick="overviewPage('<?= $referral4['ca_customer_id'] .','.  $referral4['reference_no'] . ',' .$referral4['country']. ',' .$referral4['state']. ',' .$referral4['city']. ',customer' ?>')" class="btn btn-primary view-btn">View Profile</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </button>
                    <!-- customer ref level 1 -->
                    <div class="panel">
                        <?php
                            $stmt5 = $conn -> prepare(" SELECT * FROM ca_customer WHERE reference_no = ? AND status = '1' ORDER BY ca_customer_id ASC");
                            $stmt5 -> execute([$cacus_id]);
                            $referrals5 = $stmt5->fetchAll(PDO::FETCH_ASSOC);
                            $no_team=0;
                            foreach($referrals5 as $referral5){
                                $no_team=1;
                                $customer_id = $referral5['ca_customer_id'];
                        ?>
                        <button class="accordion p-0">
                            <div class="card mb-0 rounded-0">
                                <div class="card-body p-2">
                                    <div class="row align-items-center">
                                        <div class="col-lg-4 col-md-4 col-sm-12 col-12 py-2">
                                            <div class="team-profile-img d-flex align-items-center justify-content-around">
                                                <div class="avatar-md img-thumbnail rounded float-start rounded-circle">
                                                    <img src="../../uploading/<<?=$referral5['profile_pic']?>" alt="" class="img-fluid d-block rounded-circle" />
                                                </div>
                                                <div>
                                                    <a href="#" class="d-block">
                                                        <h5 class="fs-5 mb-1"><?=$referral5['firstname'].' '.$referral5['lastname'].' '.$customer_id?></h5>
                                                    </a>
                                                    <p class="text-muted mb-0">Customer</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-md-4 col-sm-12 col-12 py-2">
                                            <div class="row text-center">
                                                <div class="col-6 border-end">
                                                    <?php
                                                        $countCU = "SELECT COUNT(ca_customer_id) AS CATAcount FROM ca_customer WHERE reference_no='".$customer_id."' ";
                                                        $cuCount = $conn -> prepare($countCU);
                                                        $cuCount -> execute();
                                                        $cuCount -> setFetchMode(PDO::FETCH_ASSOC);
                                                        if( $cuCount -> rowCount()>0 ){
                                                            foreach( ($cuCount -> fetchAll()) as $keycu => $rowcu ){
                                                                $cuCount = $rowcu['CATAcount'];
                                                    ?>
                                                    <h5 class="mb-1"><?=$cuCount?></h5>
                                                    <?php
                                                            }
                                                        }
                                                    ?>
                                                    <p class="text-muted mb-0">Total Refered Customers</p>
                                                </div>
                                                <div class="col-6">
                                                    <?php
                                                        $countPAC = "SELECT COUNT(cu_id) AS PECcount FROM product_payout WHERE cu_id='".$customer_id."' ";
                                                        $pecCount = $conn -> prepare($countPAC);
                                                        $pecCount -> execute();
                                                        $pecCount -> setFetchMode(PDO::FETCH_ASSOC);
                                                        if( $pecCount -> rowCount()>0 ){
                                                            foreach( ($pecCount -> fetchAll()) as $keyPec => $rowPec ){
                                                                $PecCount = $rowPec['PECcount'];
                                                    ?>
                                                    <h5 class="mb-1">20</h5>
                                                    <?php
                                                            }
                                                        }
                                                    ?>
                                                    <p class="text-muted mb-0">Total Packages</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-2 col-md-2 col-sm-6 col-6 py-2">
                                            <h5 class="mb-1"><?=$referral5['contact_no']?></h5>
                                            <p class="text-muted mb-0">Phone No</p>
                                        </div>
                                        <div class="col-lg-2 col-md-2 col-sm-6 col-6 py-2">
                                            <div class="text-center">
                                                <a href="#" onclick="overviewPage('<?= $referral5['ca_customer_id'] .','.  $referral5['reference_no'] . ',' .$referral5['country']. ',' .$referral5['state']. ',' .$referral5['city']. ',customer' ?>')" class="btn btn-primary view-btn">View Profile</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </button>
                        <!-- cumtomer ref level 2 -->
                        <div class="panel">
                            <?php
                                $stmt6 = $conn -> prepare(" SELECT * FROM ca_customer WHERE reference_no = ? AND status = '1' ORDER BY ca_customer_id ASC");
                                $stmt6 -> execute([$customer_id]);
                                $referrals6 = $stmt6->fetchAll(PDO::FETCH_ASSOC);
                                $no_team=0;
                                foreach($referrals6 as $referral6){
                                    $no_team=1;
                                    $customer_id2 = $referral6['ca_customer_id'];
                            ?>
                            <button class="accordion p-0">
                                <div class="card mb-0 rounded-0">
                                    <div class="card-body p-2">
                                        <div class="row align-items-center">
                                            <div class="col-lg-4 col-md-4 col-sm-12 col-12 py-2">
                                                <div class="team-profile-img d-flex align-items-center justify-content-around">
                                                    <div class="avatar-md img-thumbnail rounded float-start rounded-circle">
                                                        <img src="../../uploading/<?=$referral6['profile_pic']?>" alt="" class="img-fluid d-block rounded-circle" />
                                                    </div>
                                                    <div>
                                                        <a href="#" class="d-block">
                                                            <h5 class="fs-5 mb-1"><?=$referral6['firstname'].' '.$referral6['lastname'].' '.$customer_id2?></h5>
                                                        </a>
                                                        <p class="text-muted mb-0">Customer</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-md-4 col-sm-12 col-12 py-2">
                                                <div class="row text-center">
                                                    <div class="col-6 border-end">
                                                        <?php
                                                            $countCU2 = "SELECT COUNT(ca_customer_id) AS CATAcount FROM ca_customer WHERE reference_no='".$customer_id2."' ";
                                                            $cuCount2 = $conn -> prepare($countCU2);
                                                            $cuCount2 -> execute();
                                                            $cuCount2 -> setFetchMode(PDO::FETCH_ASSOC);
                                                            if( $cuCount2 -> rowCount()>0 ){
                                                                foreach( ($cuCount2 -> fetchAll()) as $keycu2 => $rowcu2 ){
                                                                    $cu2Count = $rowcu2['CATAcount'];
                                                        ?>
                                                        <h5 class="mb-1"><?= $cu2Count?></h5>
                                                        <?php
                                                                }
                                                            }
                                                        ?>
                                                        <p class="text-muted mb-0">Total Refered Customers</p>
                                                    </div>
                                                    <div class="col-6">
                                                        <?php
                                                            $countPAC2 = "SELECT COUNT(cu_id) AS PECcount FROM product_payout WHERE cu_id='".$customer_id2."' ";
                                                            $pecCount2 = $conn -> prepare($countPAC2);
                                                            $pecCount2 -> execute();
                                                            $pecCount2 -> setFetchMode(PDO::FETCH_ASSOC);
                                                            if( $pecCount2 -> rowCount()>0 ){
                                                                foreach( ($pecCount2 -> fetchAll()) as $keyPec2 => $rowPec2 ){
                                                                    $PecCount2 = $rowPec2['PECcount'];
                                                        ?>
                                                        <h5 class="mb-1"><?=$PecCount2?></h5>
                                                        <?php
                                                                }
                                                            }
                                                        ?>
                                                        <p class="text-muted mb-0">Total Packages</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-2 col-md-2 col-sm-6 col-6 py-2">
                                                <h5 class="mb-1"><?=$referral6['contact_no']?></h5>
                                                <p class="text-muted mb-0">Phone No</p>
                                            </div>
                                            <div class="col-lg-2 col-md-2 col-sm-6 col-6 py-2">
                                                <div class="text-center">
                                                    <a href="#" onclick="overviewPage('<?= $referral6['ca_customer_id'] .','.  $referral6['reference_no'] . ',' .$referral6['country']. ',' .$referral6['state']. ',' .$referral6['city']. ',customer' ?>')" class="btn btn-primary view-btn">View Profile</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </button>
                            <!-- cumtomer ref level 3 -->
                            <div class="panel">
                                <?php
                                    $stmt6 = $conn -> prepare(" SELECT * FROM ca_customer WHERE reference_no = ? AND status = '1' ORDER BY ca_customer_id ASC");
                                    $stmt6 -> execute([$customer_id2]);
                                    $referrals6 = $stmt6->fetchAll(PDO::FETCH_ASSOC);
                                    $no_team=0;
                                    foreach($referrals6 as $referral6){
                                        $no_team=1;
                                        $customer_id3 = $referral6['ca_customer_id'];
                                ?>
                                <button class="accordion p-0">
                                    <div class="card mb-0 rounded-0">
                                        <div class="card-body p-2">
                                            <div class="row align-items-center">
                                                <div class="col-lg-4 col-md-4 col-sm-12 col-12 py-2">
                                                    <div class="team-profile-img d-flex align-items-center justify-content-around">
                                                        <div class="avatar-md img-thumbnail rounded float-start rounded-circle">
                                                            <img src="../../uploading/<?=$referral6['profile_pic']?>" alt="" class="img-fluid d-block rounded-circle" />
                                                        </div>
                                                        <div>
                                                            <a href="#" class="d-block">
                                                                <h5 class="fs-5 mb-1"><?=$referral6['firstname'].' '.$referral6['lastname'].' '.$customer_id3?></h5>
                                                            </a>
                                                            <p class="text-muted mb-0">Customer</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4 col-md-4 col-sm-12 col-12 py-2">
                                                    <div class="row text-center">
                                                        <div class="col-6 border-end">
                                                            <?php
                                                                $countCU2 = "SELECT COUNT(ca_customer_id) AS CATAcount FROM ca_customer WHERE reference_no='".$customer_id3."' ";
                                                                $cuCount2 = $conn -> prepare($countCU2);
                                                                $cuCount2 -> execute();
                                                                $cuCount2 -> setFetchMode(PDO::FETCH_ASSOC);
                                                                if( $cuCount2 -> rowCount()>0 ){
                                                                    foreach( ($cuCount2 -> fetchAll()) as $keycu2 => $rowcu2 ){
                                                                        $cu2Count = $rowcu2['CATAcount'];
                                                            ?>
                                                            <h5 class="mb-1"><?=$cu2Count?></h5>
                                                            <?php
                                                                    }
                                                                }
                                                            ?>
                                                            <p class="text-muted mb-0">Total Refered Customers</p>
                                                        </div>
                                                        <div class="col-6">
                                                            <?php
                                                                $countPAC2 = "SELECT COUNT(cu_id) AS PECcount FROM product_payout WHERE cu_id='".$customer_id3."' ";
                                                                $pecCount2 = $conn -> prepare($countPAC2);
                                                                $pecCount2 -> execute();
                                                                $pecCount2 -> setFetchMode(PDO::FETCH_ASSOC);
                                                                if( $pecCount2 -> rowCount()>0 ){
                                                                    foreach( ($pecCount2 -> fetchAll()) as $keyPec2 => $rowPec2 ){
                                                                        $PecCount2 = $rowPec2['PECcount'];
                                                            ?>
                                                            <h5 class="mb-1"><?=$PecCount2?></h5>
                                                            <?php
                                                                    }
                                                                }
                                                            ?>
                                                            <p class="text-muted mb-0">Total Packages</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-2 col-md-2 col-sm-6 col-6 py-2">
                                                    <h5 class="mb-1"><?=$referral6['contact_no']?></h5>
                                                    <p class="text-muted mb-0">Phone No</p>
                                                </div>
                                                <div class="col-lg-2 col-md-2 col-sm-6 col-6 py-2">
                                                    <div class="text-center">
                                                        <a href="#" onclick="overviewPage('<?= $referral6['ca_customer_id'] .','.  $referral6['reference_no'] . ',' .$referral6['country']. ',' .$referral6['state']. ',' .$referral6['city']. ',customer' ?>')" class="btn btn-primary view-btn">View Profile</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </button>
                                <?php
                                    }
                                ?>
                            </div>
                            <?php
                                }
                            ?>
                            <!-- end cumtomer ref level 3 -->
                        </div>
                        <!-- end cumtomer ref level 2 -->
                        <?php
                            }
                        ?>
                    </div>
                    <!-- end customer ref level 1 -->
                    <?php
                        }
                    ?>
                </div>
                <!-- end all Customers onboarded by TC -->
            <?php
                }
            ?>
            <!-- end TC recruted by BM -->
            
        </div>
        <!-- end all TE under given BM -->
        <?php
            }
        ?>
        <?php
            $stmt2_1 = $conn -> prepare(" SELECT * FROM corporate_agency WHERE reference_no = ? AND status = '1' ORDER BY corporate_agency_id ASC");
            $stmt2_1 -> execute([$bms_id]);
            $referrals2_1 = $stmt2_1->fetchAll(PDO::FETCH_ASSOC);
            foreach($referrals2_1 as $referral2_1){
                $no_team=1;
                $tes_id = $referral2_1['corporate_agency_id']; 
        ?>
        <button class="accordion p-0">
            <div class="card mb-0 rounded-0">
                <div class="card-body p-2">
                    <div class="row align-items-center">
                        <div class="col-lg-4 col-md-4 col-sm-12 col-12 py-2">
                            <div class="team-profile-img d-flex align-items-center justify-content-around">
                                <div class="avatar-md img-thumbnail rounded float-start rounded-circle">
                                    <img src="../../uploading/<?=$referral2_1['profile_pic']?>" alt="" class="img-fluid d-block rounded-circle" />
                                </div>
                                <div>
                                    <a href="#" class="d-block">
                                        <h5 class="fs-5 mb-1"><?=$referral2_1['firstname'].' '.$referral2_1['lastname'].' '.$tes_id?></h5>
                                    </a>
                                    <p class="text-muted mb-0">Techno Enterprise</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-12 col-12 py-2">
                            <div class="row text-center">
                                <div class="col-6 border-end">
                                    <?php
                                        $countCATA2 = "SELECT COUNT(ca_travelagency_id) AS CATAcount FROM ca_travelagency WHERE reference_no='".$tes_id."' ";
                                        $cataCount2 = $conn -> prepare($countCATA2);
                                        $cataCount2 -> execute();
                                        $cataCount2 -> setFetchMode(PDO::FETCH_ASSOC);
                                        if( $cataCount2 -> rowCount()>0 ){
                                            foreach( ($cataCount2 -> fetchAll()) as $keyCATA => $rowCATA ){
                                                $CATACount2 = $rowCATA['CATAcount']; 
                                    ?>
                                    <h5 class="mb-1"><?=$CATACount2?></h5>
                                    <?php
                                            }
                                        }
                                    ?>
                                    <p class="text-muted mb-0">Total Team Member</p>
                                </div>
                                <div class="col-6">
                                    <?php
                                        $countPAC2 = "SELECT COUNT(te_id) AS PECcount FROM product_payout WHERE te_id='".$tes_id."' ";
                                        $pecCount2 = $conn -> prepare($countPAC2);
                                        $pecCount2 -> execute();
                                        $pecCount2 -> setFetchMode(PDO::FETCH_ASSOC);
                                        if( $pecCount2 -> rowCount()>0 ){
                                            foreach( ($pecCount2 -> fetchAll()) as $keyPec => $rowPec ){
                                                $PecCount2 = $rowPec['PECcount'];
                                    ?>
                                    <h5 class="mb-1"><?=$PecCount2?></h5>
                                    <?php
                                            }
                                        }
                                    ?>
                                    <p class="text-muted mb-0">Total Packages</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-2 col-sm-6 col-6 py-2">
                            <h5 class="mb-1"><?=$referral2_1['contact_no']?></h5>
                            <p class="text-muted mb-0">Phone No</p>
                        </div>
                        <div class="col-lg-2 col-md-2 col-sm-6 col-6 py-2">
                            <div class="text-center">
                                <a href="#" onclick="overviewPage('<?= $referral2_1['corporate_agency_id'] .','.  $referral2_1['reference_no'] . ',' .$referral2_1['country']. ',' .$referral2_1['state']. ',' .$referral2_1['city']. ',corporate_agency' ?>')" class="btn btn-primary view-btn">View Profile</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </button>
        <!-- TC under the given TE -->
        <div class="panel">
            <?php
                $stmt2_3 = $conn -> prepare(" SELECT * FROM ca_travelagency WHERE reference_no = ? AND status = '1' ORDER BY ca_travelagency_id ASC");
                $stmt2_3 -> execute([$tes_id]);
                $referrals2_3 = $stmt2_3->fetchAll(PDO::FETCH_ASSOC);
                foreach($referrals2_3 as $referral2){
                    $cas_id = $referral2['ca_travelagency_id'];
            ?>
            <button class="accordion p-0">
                <div class="card mb-0 rounded-0">
                    <div class="card-body p-2">
                        <div class="row align-items-center">
                            <div class="col-lg-4 col-md-4 col-sm-12 col-12 py-2">
                                <div class="team-profile-img d-flex align-items-center justify-content-around">
                                    <div class="avatar-md img-thumbnail rounded float-start rounded-circle">
                                        <img src="../../uploading/<?=$referral2['profile_pic']?>" alt="" class="img-fluid d-block rounded-circle" />
                                    </div>
                                    <div>
                                        <a href="#" class="d-block">
                                            <h5 class="fs-5 mb-1"><?=$referral2['firstname'].' '.$referral2['lastname'].' '.$cas_id?></h5>
                                        </a>
                                        <p class="text-muted mb-0">Travel Consultant</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-12 col-12 py-2">
                                <div class="row text-center">
                                    <div class="col-6 border-end">
                                        <?php
                                            $countCACU2 = "SELECT COUNT(ca_customer_id) AS CACUcount FROM ca_customer WHERE ta_reference_no='".$cas_id."' ";
                                            $cacuCount2 = $conn -> prepare($countCACU2);
                                            $cacuCount2 -> execute();
                                            $cacuCount2 -> setFetchMode(PDO::FETCH_ASSOC);
                                            if( $cacuCount2 -> rowCount()>0 ){
                                                foreach( ($cacuCount2 -> fetchAll()) as $keyCACU => $rowCACU ){
                                                    $CACUCount2 = $rowCACU['CACUcount'];
                                        ?>
                                        <h5 class="mb-1"><?=$CACUCount2?></h5>
                                        <?php
                                                }
                                            }
                                        ?>
                                        <p class="text-muted mb-0">Total Team Member</p>
                                    </div>
                                    <div class="col-6">
                                        <?php
                                            $countPAC3 = "SELECT COUNT(ta_id) AS PECcount FROM product_payout WHERE ta_id='".$cas_id."' ";
                                            $pecCount3 = $conn -> prepare($countPAC3);
                                            $pecCount3 -> execute();
                                            $pecCount3 -> setFetchMode(PDO::FETCH_ASSOC);
                                            if( $pecCount3 -> rowCount()>0 ){
                                                foreach( ($pecCount3 -> fetchAll()) as $keyPec => $rowPec ){
                                                    $PecCount3 = $rowPec['PECcount'];
                                        ?>
                                        <h5 class="mb-1"><?=$PecCount3?></h5>
                                        <?php
                                                }
                                            }
                                        ?>
                                        <p class="text-muted mb-0">Total Packages</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-2 col-md-2 col-sm-6 col-6 py-2">
                                <h5 class="mb-1"><?=$referral2['contact_no']?></h5>
                                <p class="text-muted mb-0">Phone No</p>
                            </div>
                            <div class="col-lg-2 col-md-2 col-sm-6 col-6 py-2">
                                <div class="text-center">
                                    <a href="#" onclick="overviewPage('<?= $referral2['ca_travelagency_id'] .','.  $referral2['reference_no'] . ',' .$referral2['country']. ',' .$referral2['state']. ',' .$referral2['city']. ',travel_consultant' ?>')" class="btn btn-primary view-btn">View Profile</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </button>
            <!-- all Customers onboarded by TC -->
                <div class="panel">
                    <?php
                        $stmt4 = $conn -> prepare(" SELECT * FROM ca_customer WHERE ta_reference_no = ? AND reference_no IS NUll AND status = '1' ORDER BY ca_customer_id ASC");
                        $stmt4 -> execute([$cas_id]);
                        $referrals4 = $stmt4->fetchAll(PDO::FETCH_ASSOC);
                        foreach($referrals4 as $referral4){
                            $cacus_id = $referral4['ca_customer_id'];
                    ?>
                    <button class="accordion p-0">
                        <div class="card mb-0 rounded-0">
                            <div class="card-body p-2">
                                <div class="row align-items-center">
                                    <div class="col-lg-4 col-md-4 col-sm-12 col-12 py-2">
                                        <div class="team-profile-img d-flex align-items-center justify-content-around">
                                            <div class="avatar-md img-thumbnail rounded float-start rounded-circle">
                                                <img src="../../uploading/<?=$referral4['profile_pic']?>" alt="" class="img-fluid d-block rounded-circle" />
                                            </div>
                                            <div>
                                                <a href="#" class="d-block">
                                                    <h5 class="fs-5 mb-1"><?=$referral4['firstname'].' '.$referral4['lastname'].' '.$cacus_id?></h5>
                                                </a>
                                                <p class="text-muted mb-0">Customer</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-sm-12 col-12 py-2">
                                        <div class="row text-center">
                                            <div class="col-6 border-end">
                                                <?php
                                                    $countCATACU = "SELECT COUNT(ca_customer_id) AS CATACUcount FROM ca_customer WHERE reference_no='".$cacus_id."' ";
                                                    $catacuCount = $conn -> prepare($countCATACU);
                                                    $catacuCount -> execute();
                                                    $catacuCount -> setFetchMode(PDO::FETCH_ASSOC);
                                                    if( $catacuCount -> rowCount()>0 ){
                                                        foreach( ($catacuCount -> fetchAll()) as $keyCATACU => $rowCATACU ){
                                                            $CATACUCount = $rowCATACU['CATACUcount'];
                                                ?>
                                                <h5 class="mb-1"><?=$CATACUCount?></h5>
                                                <?php
                                                        }
                                                    }
                                                ?>
                                                <p class="text-muted mb-0">Total Refered Customers</p>
                                            </div>
                                            <div class="col-6">
                                                <?php
                                                    $countPAC = "SELECT COUNT(cu_id) AS PECcount FROM product_payout WHERE cu_id='".$cacus_id."' ";
                                                    $pecCount = $conn -> prepare($countPAC);
                                                    $pecCount -> execute();
                                                    $pecCount -> setFetchMode(PDO::FETCH_ASSOC);
                                                    if( $pecCount -> rowCount()>0 ){
                                                        foreach( ($pecCount -> fetchAll()) as $keyPec => $rowPec ){
                                                            $PecCount = $rowPec['PECcount'];
                                                ?>
                                                <h5 class="mb-1"><?=$PecCount?></h5>
                                                <?php
                                                        }
                                                    }
                                                ?>
                                                <p class="text-muted mb-0">Total Packages</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-2 col-md-2 col-sm-6 col-6 py-2">
                                        <h5 class="mb-1"><?=$referral4['contact_no']?></h5>
                                        <p class="text-muted mb-0">Phone No</p>
                                    </div>
                                    <div class="col-lg-2 col-md-2 col-sm-6 col-6 py-2">
                                        <div class="text-center">
                                            <a href="#" onclick="overviewPage('<?= $referral4['ca_customer_id'] .','.  $referral4['reference_no'] . ',' .$referral4['country']. ',' .$referral4['state']. ',' .$referral4['city']. ',customer' ?>')" class="btn btn-primary view-btn">View Profile</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </button>
                    <!-- customer ref level 1 -->
                    <div class="panel">
                        <?php
                            $stmt5 = $conn -> prepare(" SELECT * FROM ca_customer WHERE reference_no = ? AND status = '1' ORDER BY ca_customer_id ASC");
                            $stmt5 -> execute([$cacus_id]);
                            $referrals5 = $stmt5->fetchAll(PDO::FETCH_ASSOC);
                            foreach($referrals5 as $referral5){
                                $customer_id = $referral5['ca_customer_id'];
                        ?>
                        <button class="accordion p-0">
                            <div class="card mb-0 rounded-0">
                                <div class="card-body p-2">
                                    <div class="row align-items-center">
                                        <div class="col-lg-4 col-md-4 col-sm-12 col-12 py-2">
                                            <div class="team-profile-img d-flex align-items-center justify-content-around">
                                                <div class="avatar-md img-thumbnail rounded float-start rounded-circle">
                                                    <img src="../../uploading/<<?=$referral5['profile_pic']?>" alt="" class="img-fluid d-block rounded-circle" />
                                                </div>
                                                <div>
                                                    <a href="#" class="d-block">
                                                        <h5 class="fs-5 mb-1"><?=$referral5['firstname'].' '.$referral5['lastname'].' '.$customer_id?></h5>
                                                    </a>
                                                    <p class="text-muted mb-0">Customer</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-md-4 col-sm-12 col-12 py-2">
                                            <div class="row text-center">
                                                <div class="col-6 border-end">
                                                    <?php
                                                        $countCU = "SELECT COUNT(ca_customer_id) AS CATAcount FROM ca_customer WHERE reference_no='".$customer_id."' ";
                                                        $cuCount = $conn -> prepare($countCU);
                                                        $cuCount -> execute();
                                                        $cuCount -> setFetchMode(PDO::FETCH_ASSOC);
                                                        if( $cuCount -> rowCount()>0 ){
                                                            foreach( ($cuCount -> fetchAll()) as $keycu => $rowcu ){
                                                                $cuCount = $rowcu['CATAcount'];
                                                    ?>
                                                    <h5 class="mb-1"><?=$cuCount?></h5>
                                                    <?php
                                                            }
                                                        }
                                                    ?>
                                                    <p class="text-muted mb-0">Total Refered Customers</p>
                                                </div>
                                                <div class="col-6">
                                                    <?php
                                                        $countPAC = "SELECT COUNT(cu_id) AS PECcount FROM product_payout WHERE cu_id='".$customer_id."' ";
                                                        $pecCount = $conn -> prepare($countPAC);
                                                        $pecCount -> execute();
                                                        $pecCount -> setFetchMode(PDO::FETCH_ASSOC);
                                                        if( $pecCount -> rowCount()>0 ){
                                                            foreach( ($pecCount -> fetchAll()) as $keyPec => $rowPec ){
                                                                $PecCount = $rowPec['PECcount'];
                                                    ?>
                                                    <h5 class="mb-1">20</h5>
                                                    <?php
                                                            }
                                                        }
                                                    ?>
                                                    <p class="text-muted mb-0">Total Packages</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-2 col-md-2 col-sm-6 col-6 py-2">
                                            <h5 class="mb-1"><?=$referral5['contact_no']?></h5>
                                            <p class="text-muted mb-0">Phone No</p>
                                        </div>
                                        <div class="col-lg-2 col-md-2 col-sm-6 col-6 py-2">
                                            <div class="text-center">
                                                <a href="#" onclick="overviewPage('<?= $referral5['ca_customer_id'] .','.  $referral5['reference_no'] . ',' .$referral5['country']. ',' .$referral5['state']. ',' .$referral5['city']. ',customer' ?>')" class="btn btn-primary view-btn">View Profile</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </button>
                        <!-- cumtomer ref level 2 -->
                        <div class="panel">
                            <?php
                                $stmt6 = $conn -> prepare(" SELECT * FROM ca_customer WHERE reference_no = ? AND status = '1' ORDER BY ca_customer_id ASC");
                                $stmt6 -> execute([$customer_id]);
                                $referrals6 = $stmt6->fetchAll(PDO::FETCH_ASSOC);
                                foreach($referrals6 as $referral6){
                                    $customer_id2 = $referral6['ca_customer_id'];
                            ?>
                            <button class="accordion p-0">
                                <div class="card mb-0 rounded-0">
                                    <div class="card-body p-2">
                                        <div class="row align-items-center">
                                            <div class="col-lg-4 col-md-4 col-sm-12 col-12 py-2">
                                                <div class="team-profile-img d-flex align-items-center justify-content-around">
                                                    <div class="avatar-md img-thumbnail rounded float-start rounded-circle">
                                                        <img src="../../uploading/<?=$referral6['profile_pic']?>" alt="" class="img-fluid d-block rounded-circle" />
                                                    </div>
                                                    <div>
                                                        <a href="#" class="d-block">
                                                            <h5 class="fs-5 mb-1"><?=$referral6['firstname'].' '.$referral6['lastname'].' '.$customer_id2?></h5>
                                                        </a>
                                                        <p class="text-muted mb-0">Customer</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-md-4 col-sm-12 col-12 py-2">
                                                <div class="row text-center">
                                                    <div class="col-6 border-end">
                                                        <?php
                                                            $countCU2 = "SELECT COUNT(ca_customer_id) AS CATAcount FROM ca_customer WHERE reference_no='".$customer_id2."' ";
                                                            $cuCount2 = $conn -> prepare($countCU2);
                                                            $cuCount2 -> execute();
                                                            $cuCount2 -> setFetchMode(PDO::FETCH_ASSOC);
                                                            if( $cuCount2 -> rowCount()>0 ){
                                                                foreach( ($cuCount2 -> fetchAll()) as $keycu2 => $rowcu2 ){
                                                                    $cu2Count = $rowcu2['CATAcount'];
                                                        ?>
                                                        <h5 class="mb-1"><?= $cu2Count?></h5>
                                                        <?php
                                                                }
                                                            }
                                                        ?>
                                                        <p class="text-muted mb-0">Total Refered Customers</p>
                                                    </div>
                                                    <div class="col-6">
                                                        <?php
                                                            $countPAC2 = "SELECT COUNT(cu_id) AS PECcount FROM product_payout WHERE cu_id='".$customer_id2."' ";
                                                            $pecCount2 = $conn -> prepare($countPAC2);
                                                            $pecCount2 -> execute();
                                                            $pecCount2 -> setFetchMode(PDO::FETCH_ASSOC);
                                                            if( $pecCount2 -> rowCount()>0 ){
                                                                foreach( ($pecCount2 -> fetchAll()) as $keyPec2 => $rowPec2 ){
                                                                    $PecCount2 = $rowPec2['PECcount'];
                                                        ?>
                                                        <h5 class="mb-1"><?=$PecCount2?></h5>
                                                        <?php
                                                                }
                                                            }
                                                        ?>
                                                        <p class="text-muted mb-0">Total Packages</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-2 col-md-2 col-sm-6 col-6 py-2">
                                                <h5 class="mb-1"><?=$referral6['contact_no']?></h5>
                                                <p class="text-muted mb-0">Phone No</p>
                                            </div>
                                            <div class="col-lg-2 col-md-2 col-sm-6 col-6 py-2">
                                                <div class="text-center">
                                                    <a href="#" onclick="overviewPage('<?= $referral6['ca_customer_id'] .','.  $referral6['reference_no'] . ',' .$referral6['country']. ',' .$referral6['state']. ',' .$referral6['city']. ',customer' ?>')" class="btn btn-primary view-btn">View Profile</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </button>
                            <!-- cumtomer ref level 3 -->
                            <div class="panel">
                                <?php
                                    $stmt6 = $conn -> prepare(" SELECT * FROM ca_customer WHERE reference_no = ? AND status = '1' ORDER BY ca_customer_id ASC");
                                    $stmt6 -> execute([$customer_id2]);
                                    $referrals6 = $stmt6->fetchAll(PDO::FETCH_ASSOC);
                                    foreach($referrals6 as $referral6){
                                        $customer_id3 = $referral6['ca_customer_id'];
                                ?>
                                <button class="accordion p-0">
                                    <div class="card mb-0 rounded-0">
                                        <div class="card-body p-2">
                                            <div class="row align-items-center">
                                                <div class="col-lg-4 col-md-4 col-sm-12 col-12 py-2">
                                                    <div class="team-profile-img d-flex align-items-center justify-content-around">
                                                        <div class="avatar-md img-thumbnail rounded float-start rounded-circle">
                                                            <img src="../../uploading/<?=$referral6['profile_pic']?>" alt="" class="img-fluid d-block rounded-circle" />
                                                        </div>
                                                        <div>
                                                            <a href="#" class="d-block">
                                                                <h5 class="fs-5 mb-1"><?=$referral6['firstname'].' '.$referral6['lastname'].' '.$customer_id3?></h5>
                                                            </a>
                                                            <p class="text-muted mb-0">Customer</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4 col-md-4 col-sm-12 col-12 py-2">
                                                    <div class="row text-center">
                                                        <div class="col-6 border-end">
                                                            <?php
                                                                $countCU2 = "SELECT COUNT(ca_customer_id) AS CATAcount FROM ca_customer WHERE reference_no='".$customer_id3."' ";
                                                                $cuCount2 = $conn -> prepare($countCU2);
                                                                $cuCount2 -> execute();
                                                                $cuCount2 -> setFetchMode(PDO::FETCH_ASSOC);
                                                                if( $cuCount2 -> rowCount()>0 ){
                                                                    foreach( ($cuCount2 -> fetchAll()) as $keycu2 => $rowcu2 ){
                                                                        $cu2Count = $rowcu2['CATAcount'];
                                                            ?>
                                                            <h5 class="mb-1"><?=$cu2Count?></h5>
                                                            <?php
                                                                    }
                                                                }
                                                            ?>
                                                            <p class="text-muted mb-0">Total Refered Customers</p>
                                                        </div>
                                                        <div class="col-6">
                                                            <?php
                                                                $countPAC2 = "SELECT COUNT(cu_id) AS PECcount FROM product_payout WHERE cu_id='".$customer_id3."' ";
                                                                $pecCount2 = $conn -> prepare($countPAC2);
                                                                $pecCount2 -> execute();
                                                                $pecCount2 -> setFetchMode(PDO::FETCH_ASSOC);
                                                                if( $pecCount2 -> rowCount()>0 ){
                                                                    foreach( ($pecCount2 -> fetchAll()) as $keyPec2 => $rowPec2 ){
                                                                        $PecCount2 = $rowPec2['PECcount'];
                                                            ?>
                                                            <h5 class="mb-1"><?=$PecCount2?></h5>
                                                            <?php
                                                                    }
                                                                }
                                                            ?>
                                                            <p class="text-muted mb-0">Total Packages</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-2 col-md-2 col-sm-6 col-6 py-2">
                                                    <h5 class="mb-1"><?=$referral6['contact_no']?></h5>
                                                    <p class="text-muted mb-0">Phone No</p>
                                                </div>
                                                <div class="col-lg-2 col-md-2 col-sm-6 col-6 py-2">
                                                    <div class="text-center">
                                                        <a href="#" onclick="overviewPage('<?= $referral6['ca_customer_id'] .','.  $referral6['reference_no'] . ',' .$referral6['country']. ',' .$referral6['state']. ',' .$referral6['city']. ',customer' ?>')" class="btn btn-primary view-btn">View Profile</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </button>
                                <?php
                                    }
                                ?>
                            </div>
                            <?php
                                }
                            ?>
                            <!-- end cumtomer ref level 3 -->
                        </div>
                        <!-- end cumtomer ref level 2 -->
                        <?php
                            }
                        ?>
                    </div>
                    <!-- end customer ref level 1 -->
                    <?php
                        }
                    ?>
                </div>
                <!-- end all Customers onboarded by TC -->
            <?php
                }
            ?>
            <!-- end TC under the given TE -->
            </div>
        <?php
            }
        ?>
        
        
        
    </div>
</div>