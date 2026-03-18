<!-- system user count, total revenue, pending and paid commission  -->
<div class="col-xl-12">
    <div class="row">
        <div class="col-lg-3 col-md-3 col-sm-6 col-12">
            <div class="card card-equal mini-stats-wid rounded-4">
                <div class="card-body">
                    <div class="d-flex">
                        <div class="flex-shrink-1">
                            <div class="mini-stat-icon avatar-sm rounded-circle bg-primary">
                                <span class="avatar-title">
                                    <i class="fas fa-user-alt font-size-24"></i>
                                </span>
                            </div>
                        </div>
                        <div class="flex-grow-1 ps-2">
                            <p class="text-muted fw-medium">Total Customers</p>
                            <?php
                                $stmt = $conn->prepare("SELECT COUNT(ca_customer_id) as totalca_customer FROM ca_customer WHERE user_type='10' AND status='1'");
                                $stmt->execute();
                                $stmt->setFetchMode(PDO::FETCH_ASSOC);
                                if ($stmt->rowCount() > 0) {
                                    foreach (($stmt->fetchAll()) as $key => $row) {
                                        echo '<h3 class="mb-0 text-dark">'.$row['totalca_customer'].'</h3>';
                                    }
                                } else {
                                    echo '<h3 class="mb-0 text-dark">0</h3>';
                                }
                            ?>
                        </div>
                    </div>
                    <div class="d-flex justify-content-center my-3">
                        <a href="../ca_customer/view_customers.php" class="text-primary-emphasis bg-primary-subtle border border-primary-subtle rounded-3 fw-bolder text-center py-1 viewDetailsButton1" role="button" style="width: 190px;">View details</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Franchisee | TE | Institution -->
        <div class="col-lg-3 col-md-3 col-sm-6 col-12">
            <div class="card card-equal mini-stats-wid rounded-4">
                <div class="card-body">
                    <div class="d-flex">
                        <div class="flex-shrink-1">
                            <div class="mini-stat-icon avatar-sm rounded-circle bg-success">
                                <span class="avatar-title1">
                                    <i class="fa-solid fa-users-between-lines font-size-24"></i>
                                </span>
                            </div>
                        </div>
                        <div class="flex-grow-1 ps-2">
                            <p class="text-muted fw-medium">Franchisee | TE | Institution</p>
                            <?php
                                $stmt = $conn->prepare("
                                    SELECT 
                                        COALESCE((SELECT COUNT(corporate_agency_id) FROM corporate_agency WHERE user_type='16'),0) +
                                        COALESCE((SELECT COUNT(sub_franchisee_id) FROM sub_franchisee WHERE user_type='29'),0) +
                                        COALESCE((SELECT COUNT(institution_id) FROM institution WHERE user_type='32' AND status='1'),0)
                                    AS total_users
                                ");
                                $stmt->execute();
                                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                                echo '<h3 class="mb-0 text-dark">'.($row['total_users'] ?? 0).'</h3>';
                            ?>
                        </div>
                    </div>
                    <div class="d-flex justify-content-center my-3">
                        <a href="../corporate_agency/view_corporate_agency.php" class="text-success-emphasis bg-success-subtle border border-success-subtle rounded-3 fw-bolder text-center py-1 viewDetailsButton2" role="button" style="width: 190px;">View details</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Revenue -->
        <div class="col-md-6 col-sm-9 col-12">
            <div class="card card-equal mini-stats-wid rounded-4">
                <div class="card-body">
                    <div class="d-flex">
                        <div class="flex-fill">
                            <div class="mini-stat-icon avatar-sm rounded-circle bg-warning">
                                <span class="avatar-title2">
                                    <i class="fa-solid fa-wallet font-size-24"></i>
                                </span>
                            </div>
                        </div>
                        <div class="flex-fill">
                            <p class="text-muted fw-medium ps-2">Revenue Generated Full</p>
                            <?php
                                $stmt = $conn->prepare("
                                    SELECT SUM(total) AS total_revenue
                                    FROM (
                                        SELECT COALESCE(SUM(amount),0) AS total FROM corporate_agency WHERE user_type='16'
                                        UNION ALL
                                        SELECT COALESCE(SUM(amount),0) FROM sub_franchisee WHERE user_type='29'
                                        UNION ALL
                                        SELECT COALESCE(SUM(amount),0) FROM institution WHERE user_type='32'
                                        UNION ALL
                                        SELECT COALESCE(SUM(paid_amount),0) FROM business_mentor WHERE user_type='26'
                                        UNION ALL
                                        SELECT COALESCE(SUM(paid_amount),0) FROM master_franchisee WHERE user_type='28'
                                        UNION ALL
                                        SELECT COALESCE(SUM(paid_amount),0) FROM sponsor_franchisee WHERE user_type='30'
                                        UNION ALL
                                        SELECT COALESCE(SUM(amount),0) FROM ca_travelagency WHERE user_type='11'
                                        UNION ALL
                                        SELECT COALESCE(SUM(paid_amount),0) FROM ca_customer WHERE user_type='10' AND status='1'
                                    ) t
                                ");
                                $stmt->execute();
                                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                                echo '<h3 class="mb-0 text-dark">&#8377;'.formatIndianCurrency($row['total_revenue'] ?? 0).'</h3>';
                            ?>
                        </div>
                        <div class="flex-fill">
                            <img src="../../assets/images/goldcoin.png" style="width: 165px; height: 110px;" alt="">
                        </div>
                    </div>
                    <div class="d-flex justify-content-center my-3 revenueCardViewButton">
                        <a href="../payout/sub_franchisee_payout.php" class="text-warning-emphasis bg-warning-subtle border border-warning-subtle rounded-3 fw-bolder text-center py-1 viewDetailsButton3" role="button" style="width: 190px;">View details</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Travel Consultant -->
        <div class="col-md-3 col-sm-6 col-12">
            <div class="card card-equal mini-stats-wid rounded-4">
                <div class="card-body">
                    <div class="d-flex">
                        <div class="flex-shrink-1">
                            <div class="mini-stat-icon avatar-sm rounded-circle bg-primary">
                                <span class="avatar-title">
                                    <i class="fas fa-user-alt font-size-24"></i>
                                </span>
                            </div>
                        </div>
                        <div class="flex-grow-1 ps-2">
                            <p class="text-muted fw-medium">Travel Consultant</p>
                            <?php
                                $stmt = $conn->prepare("SELECT COUNT(ca_travelagency_id) as totalca_travelagency FROM ca_travelagency WHERE user_type='11' AND status='1'");
                                $stmt->execute();
                                $stmt->setFetchMode(PDO::FETCH_ASSOC);
                                if ($stmt->rowCount() > 0) {
                                    foreach (($stmt->fetchAll()) as $key => $row) {
                                        echo '<h3 class="mb-0 text-dark">'.$row['totalca_travelagency'].'</h3>';
                                    }
                                } else {
                                    echo '<h3 class="mb-0 text-dark">0</h3>';
                                }
                            ?>
                        </div>
                    </div>
                    <div class="d-flex justify-content-center my-3">
                        <a href="../ca_travel_agency/view_ca_travelAgency.php" class="text-primary-emphasis bg-primary-subtle border border-primary-subtle rounded-3 fw-bolder text-center py-1 viewDetailsButton1" role="button" style="width: 190px;">View details</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- MF | SF | BM -->
        <div class="col-md-3 col-sm-6 col-12">
            <div class="card card-equal mini-stats-wid rounded-4">
                <div class="card-body">
                    <div class="d-flex">
                        <div class="flex-shrink-1">
                            <div class="mini-stat-icon avatar-sm rounded-circle bg-success">
                                <span class="avatar-title1">
                                    <i class="fa-solid fa-users-between-lines font-size-24"></i>
                                </span>
                            </div>
                        </div>
                        <div class="flex-grow-1 ps-2">
                            <p class="text-muted fw-medium">MF | SF | BM</p>
                            <?php
                                $stmt = $conn->prepare("
                                    SELECT 
                                        COALESCE((SELECT COUNT(business_mentor_id) FROM business_mentor WHERE user_type='26'),0) +
                                        COALESCE((SELECT COUNT(master_franchisee_id) FROM master_franchisee WHERE user_type='28'),0) +
                                        COALESCE((SELECT COUNT(sponsor_franchisee_id) FROM sponsor_franchisee WHERE user_type='30' AND status='1'),0)
                                    AS total_users
                                ");
                                $stmt->execute();
                                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                                echo '<h3 class="mb-0 text-dark">'.($row['total_users'] ?? 0).'</h3>';
                            ?>
                        </div>
                    </div>
                    <div class="d-flex justify-content-center my-3">
                        <a href="../business_mentor/businessMentor.php" class="text-success-emphasis bg-success-subtle border border-success-subtle rounded-3 fw-bolder text-center py-1 viewDetailsButton2" role="button" style="width: 190px;">View details</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 col-12">
            <div class="card card-equal mini-stats-wid rounded-4">
                <div class="card-body">
                    <div class="d-flex">
                        <div class="flex-shrink-1">
                            <div class="mini-stat-icon avatar-sm rounded-circle bg-warning">
                                <span class="avatar-title2">
                                    <i class="fa-solid fa-wallet font-size-24"></i>
                                </span>
                            </div>
                        </div>
                        <div class="flex-grow-1 ps-2">
                            <p class="text-muted fw-medium">Commission Paid</p>
                            <?php
                                $stmt = $conn->prepare("
                                    SELECT 
                                        COALESCE((SELECT SUM(payout_amount) FROM bm_payout_history WHERE payout_status='1'),0) + 
                                        COALESCE((SELECT SUM(comm_amt) FROM bm_recruitment_payout WHERE status='1'),0) +
                                        COALESCE((SELECT SUM(comm_amt) FROM goa_bm_payout WHERE status='1'),0) +

                                        COALESCE((SELECT SUM(comm_amt) FROM ca_payout WHERE status='1'),0) +

                                        COALESCE((SELECT 
                                            SUM(CASE WHEN status_zm = '1' THEN commission_zm ELSE 0 END) +
                                            SUM(CASE WHEN status_mf = '1' THEN commission_mf ELSE 0 END)
                                        FROM sub_franchisee_payout),0) +

                                        COALESCE((SELECT 
                                            SUM(CASE WHEN status_emp = '1' THEN commission_emp ELSE 0 END) +
                                            SUM(CASE WHEN status_bm_mf_sf = '1' THEN commission_bm_mf_sf ELSE 0 END)
                                        FROM institution_payout),0) +

                                        COALESCE((SELECT 
                                            SUM(CASE WHEN status_bm = '1' THEN commision_bm ELSE 0 END) +
                                            SUM(CASE WHEN status_te = '1' THEN commision_te ELSE 0 END)
                                        FROM ca_ta_payout),0) +

                                        COALESCE((SELECT 
                                            SUM(CASE WHEN status_bdm = '1' THEN commision_bdm ELSE 0 END) +
                                            SUM(CASE WHEN status_bm = '1' THEN commision_bm ELSE 0 END) +
                                            SUM(CASE WHEN status_te = '1' THEN commision_te ELSE 0 END) 
                                        FROM ca_cu_payout),0) +

                                        COALESCE((SELECT SUM(referral_amount) FROM customer_reference_payout WHERE status='1'),0) +

                                        COALESCE((SELECT 
                                            SUM(CASE WHEN ta_status = '1' THEN ta_amt ELSE 0 END) +
                                            SUM(CASE WHEN te_status = '1' THEN te_amt ELSE 0 END) +
                                            SUM(CASE WHEN bm_status = '1' THEN bm_amt ELSE 0 END) +
                                            SUM(CASE WHEN cu1_status = '1' THEN cu1_amt ELSE 0 END) +
                                            SUM(CASE WHEN cu2_status = '1' THEN cu2_amt ELSE 0 END) +
                                            SUM(CASE WHEN cu3_status = '1' THEN cu3_amt ELSE 0 END) 
                                        FROM product_payout),0)

                                    AS commission_paid;
                                ");
                                $stmt->execute();
                                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                                $commission_paid = $row['commission_paid'] ?? 0;
                                echo '<h3 class="mb-0 text-dark">&#8377;'.formatIndianCurrency($commission_paid).'</h3>';
                            ?>
                            <!-- <h3 class="mb-0 text-dark commissionAmount">&#8377; 3,264L</h3> -->
                        </div>
                    </div>
                    <div class="d-flex justify-content-center my-3">
                        <a href="../payout/sub_franchisee_payout.php" class="text-warning-emphasis bg-warning-subtle border border-warning-subtle rounded-3 fw-bolder text-center py-1 viewDetailsButton3" role="button" style="width: 190px;">View details</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 col-12">
            <div class="card card-equal mini-stats-wid rounded-4">
                <div class="card-body">
                    <div class="d-flex">
                        <div class="flex-shrink-1">
                            <div class="mini-stat-icon avatar-sm rounded-circle bg-danger">
                                <span class="avatar-title3">
                                    <i class="fa-solid fa-wallet font-size-24"></i>
                                </span>;
                            </div>
                        </div>
                        <div class="flex-grow-1 ps-2">
                            <p class="text-muted fw-medium">Commission Pending</p>
                            <?php
                                $stmt = $conn->prepare("
                                    SELECT 
                                        COALESCE((SELECT SUM(payout_amount) FROM bm_payout_history WHERE payout_status='2'),0) + 
                                        COALESCE((SELECT SUM(comm_amt) FROM bm_recruitment_payout WHERE status='2'),0) +
                                        COALESCE((SELECT SUM(comm_amt) FROM goa_bm_payout WHERE status='2'),0) +

                                        COALESCE((SELECT SUM(comm_amt) FROM ca_payout WHERE status='2'),0) +

                                        COALESCE((SELECT 
                                            SUM(CASE WHEN status_zm = '2' THEN commission_zm ELSE 0 END) +
                                            SUM(CASE WHEN status_mf = '2' THEN commission_mf ELSE 0 END)
                                        FROM sub_franchisee_payout),0) +

                                        COALESCE((SELECT 
                                            SUM(CASE WHEN status_emp = '2' THEN commission_emp ELSE 0 END) +
                                            SUM(CASE WHEN status_bm_mf_sf = '2' THEN commission_bm_mf_sf ELSE 0 END)
                                        FROM institution_payout),0) +

                                        COALESCE((SELECT 
                                            SUM(CASE WHEN status_bm = '2' THEN commision_bm ELSE 0 END) +
                                            SUM(CASE WHEN status_te = '2' THEN commision_te ELSE 0 END)
                                        FROM ca_ta_payout),0) +

                                        COALESCE((SELECT 
                                            SUM(CASE WHEN status_bdm = '2' THEN commision_bdm ELSE 0 END) +
                                            SUM(CASE WHEN status_bm = '2' THEN commision_bm ELSE 0 END) +
                                            SUM(CASE WHEN status_te = '2' THEN commision_te ELSE 0 END) 
                                        FROM ca_cu_payout),0) +

                                        COALESCE((SELECT SUM(referral_amount) FROM customer_reference_payout WHERE status='2'),0) +

                                        COALESCE((SELECT 
                                            SUM(CASE WHEN ta_status = '2' THEN ta_amt ELSE 0 END) +
                                            SUM(CASE WHEN te_status = '2' THEN te_amt ELSE 0 END) +
                                            SUM(CASE WHEN bm_status = '2' THEN bm_amt ELSE 0 END) +
                                            SUM(CASE WHEN cu1_status = '2' THEN cu1_amt ELSE 0 END) +
                                            SUM(CASE WHEN cu2_status = '2' THEN cu2_amt ELSE 0 END) +
                                            SUM(CASE WHEN cu3_status = '2' THEN cu3_amt ELSE 0 END) 
                                        FROM product_payout),0)

                                    AS commission_pending;
                                ");
                                $stmt->execute();
                                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                                $commission_pending = $row['commission_pending'] ?? 0;
                                echo '<h3 class="mb-0 text-dark">&#8377;'.formatIndianCurrency($commission_pending).'</h3>';
                            ?>
                            <!-- <h3 class="mb-0 text-dark commissionAmount">&#8377; 15.<span class="text-danger">25%</span></h3> -->
                        </div>
                    </div>
                    <div class="d-flex justify-content-center my-3">
                        <a href="../payout/sub_franchisee_payout.php" class="text-danger-emphasis bg-danger-subtle border border-danger-subtle rounded-3 fw-bolder text-center py-1 viewDetailsButton4" role="button" style="width: 190px;">View details</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>