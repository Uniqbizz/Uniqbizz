<!-- New Card Template Start -->
<div class="row">
    <!-- BDM -->
    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-12">
        <div class="card rounded-4 pt-3 pb-2 px-4 cardBg1">
            <div>
                <p class="text-white fw-bold fs-11">Business Development Manager</p>
            </div>
            <div class="d-flex justify-content-between align-items-center mb-1">
                <span class="">
                    <i class="fa-regular fa-user fa-2xl" style="color: #ffffff;"></i>
                </span>
                <div class="ms-4">
                    <?php
                    $sql3 = "SELECT COUNT(employee_id) as id FROM employees WHERE reporting_manager = '" . $userId . "' AND user_type = '25' AND status = '1'";
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
                    <!-- <h1 class="mb-0 text-white">486</h1> -->
                </div>
            </div>
            <div class="d-flex justify-content-between">
                <p class="text-white">This Month</p>
                <?php
                $sql3 = "SELECT COUNT(employee_id) as id FROM employees WHERE reporting_manager = '" . $userId . "' AND user_type = '25' AND YEAR(register_date) = '" . $DateYear . "' AND MONTH(register_date) = '" . $DateMonth . "' AND status = '1'";
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
    <!-- BM -->
    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-12">
        <div class="card rounded-4 pt-3 pb-2 px-4 cardBg2">
            <div>
                <p class="text-white fw-bold fs-11">Business Mentor</p>
            </div>
            <div class="d-flex justify-content-between align-items-center mb-1">
                <span class="">
                    <i class="fa-regular fa-user fa-2xl" style="color: #ffffff;"></i>
                </span>
                <div class="ms-4">
                    <?php
                        $sql = "SELECT COUNT(bm.business_mentor_id) AS id
                                FROM employees AS bcm
                                JOIN employees AS bdm ON bdm.reporting_manager = bcm.employee_id AND bdm.user_type = 25 AND bdm.status='1'
                                JOIN business_mentor AS bm ON bm.reference_no = bdm.employee_id AND bm.user_type = 26 AND bm.status = '1'
                                WHERE bcm.user_type = 24 AND bcm.employee_id = :bcm_id";

                        $stmt = $conn->prepare($sql);
                        $stmt->execute([':bcm_id' => $userId]);
                        $stmt->setFetchMode(PDO::FETCH_ASSOC);

                        if ($stmt->rowCount() > 0) {
                            $row = $stmt->fetch();
                            echo '<h1 class="mb-0 text-white">' . $row['id'] . '</h1>';
                        }

                    ?>
                    <!-- <h1 class="mb-0 text-white">486</h1> -->
                </div>
            </div>
            <div class="d-flex justify-content-between">
                <p class="text-white">This Month</p>
                <?php
                    $sql3 = "SELECT COUNT(bm.business_mentor_id) AS id
                            FROM employees AS bcm
                            JOIN employees AS bdm ON bdm.reporting_manager = bcm.employee_id AND bdm.user_type = 25 AND bdm.status='1'
                            JOIN business_mentor AS bm ON bm.reference_no = bdm.employee_id AND bm.user_type = 26 AND bm.status = '1'
                            WHERE bcm.user_type = 24 
                            AND bcm.employee_id = :bcm_id
                            AND YEAR(bm.register_date) = :year
                            AND MONTH(bm.register_date) = :month";

                    $stmt3 = $conn->prepare($sql3);
                    $stmt3->execute([
                        ':bcm_id' => $userId,
                        ':year'   => $DateYear,
                        ':month'  => $DateMonth
                    ]);
                    $stmt3->setFetchMode(PDO::FETCH_ASSOC);

                    if ($stmt3->rowCount() > 0) {
                        $row = $stmt3->fetch();
                        echo '<p class="text-white">' . $row['id'] . '</p>';
                    }

                ?>

            </div>
        </div>
    </div>
    <!-- MF -->
    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-12">
        <div class="card rounded-4 pt-3 pb-2 px-4 cardBg3">
            <div>
                <p class="text-white fw-bold fs-11">Master Franchisee</p>
            </div>
            <div class="d-flex justify-content-between align-items-center mb-1">
                <span class="">
                    <i class="fa-regular fa-user fa-2xl" style="color: #ffffff;"></i>
                </span>
                <div class="ms-4">
                    <?php
                    $sql3 = "SELECT COUNT(bm.master_franchisee_id) AS id
                                FROM employees AS bcm
                                JOIN employees AS bdm ON bdm.reporting_manager = bcm.employee_id AND bdm.user_type = 25 AND bdm.status='1'
                                JOIN master_franchisee AS bm ON bm.reference_no = bdm.employee_id AND bm.user_type = 26 AND bm.status = '1'
                                WHERE bcm.user_type = 24 AND bcm.employee_id = :bcm_id";
                    $stmt3 = $conn->prepare($sql3);
                    $stmt3->execute([':bcm_id' => $userId]);
                    $stmt3->setFetchMode(PDO::FETCH_ASSOC);
                    if ($stmt3->rowCount() > 0) {
                        foreach (($stmt3->fetchAll()) as $key => $row) {
                            $id = $row['id'];
                            echo '<h1 class="mb-0 text-white">' . $id . '</h1>';
                        }
                    }
                    ?>
                    <!-- <h1 class="mb-0 text-white">486</h1> -->
                </div>
            </div>
            <div class="d-flex justify-content-between">
                <p class="text-white">This Month</p>
                <?php
                $sql3 = "SELECT COUNT(bm.master_franchisee_id) AS id
                            FROM employees AS bcm
                            JOIN employees AS bdm ON bdm.reporting_manager = bcm.employee_id AND bdm.user_type = 25 AND bdm.status='1'
                            JOIN master_franchisee AS bm ON bm.reference_no = bdm.employee_id AND bm.user_type = 26 AND bm.status = '1'
                            WHERE bcm.user_type = 24 
                            AND bcm.employee_id = :bcm_id
                            AND YEAR(bm.register_date) = :year
                            AND MONTH(bm.register_date) = :month";
                $stmt3 = $conn->prepare($sql3);
                $stmt3->execute([
                        ':bcm_id' => $userId,
                        ':year'   => $DateYear,
                        ':month'  => $DateMonth
                    ]);
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
    <!-- SF -->
    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-12">
        <div class="card rounded-4 pt-3 pb-2 px-4 cardBg4">
            <div>
                <p class="text-white fw-bold fs-11">Sponsor Franchisee</p>
            </div>
            <div class="d-flex justify-content-between align-items-center mb-1">
                <span class="">
                    <i class="fa-regular fa-user fa-2xl" style="color: #ffffff;"></i>
                </span>
                <div class="ms-4">
                    <?php
                    $sql3 = "SELECT COUNT(bm.sponsor_franchisee_id) AS id
                                FROM employees AS bcm
                                JOIN employees AS bdm ON bdm.reporting_manager = bcm.employee_id AND bdm.user_type = 25 AND bdm.status='1'
                                JOIN sponsor_franchisee AS bm ON bm.reference_no = bdm.employee_id AND bm.user_type = 26 AND bm.status = '1'
                                WHERE bcm.user_type = 24 AND bcm.employee_id = :bcm_id";
                    $stmt3 = $conn->prepare($sql3);
                    $stmt3->execute([':bcm_id' => $userId]);
                    $stmt3->setFetchMode(PDO::FETCH_ASSOC);
                    if ($stmt3->rowCount() > 0) {
                        foreach (($stmt3->fetchAll()) as $key => $row) {
                            $id = $row['id'];
                            echo '<h1 class="mb-0 text-white">' . $id . '</h1>';
                        }
                    }
                    ?>
                    <!-- <h1 class="mb-0 text-white">486</h1> -->
                </div>
            </div>
            <div class="d-flex justify-content-between">
                <p class="text-white">This Month</p>
                <?php
                $sql3 = "SELECT COUNT(bm.sponsor_franchisee_id) AS id
                            FROM employees AS bcm
                            JOIN employees AS bdm ON bdm.reporting_manager = bcm.employee_id AND bdm.user_type = 25 AND bdm.status='1'
                            JOIN sponsor_franchisee AS bm ON bm.reference_no = bdm.employee_id AND bm.user_type = 26 AND bm.status = '1'
                            WHERE bcm.user_type = 24 
                            AND bcm.employee_id = :bcm_id
                            AND YEAR(bm.register_date) = :year
                            AND MONTH(bm.register_date) = :month";
                $stmt3 = $conn->prepare($sql3);
                $stmt3->execute([
                        ':bcm_id' => $userId,
                        ':year'   => $DateYear,
                        ':month'  => $DateMonth
                    ]);
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
</div>
<div class="row">
    <!-- TE -->
    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-12">
        <div class="card rounded-4 pt-3 pb-2 px-4 cardBg5">
            <div>
                <p class="text-white fw-bold fs-11">Techno Enterprise</p>
            </div>
            <div class="d-flex justify-content-between align-items-center mb-1">
                <span class="">
                    <i class="fa-regular fa-user fa-2xl" style="color: #ffffff;"></i>
                </span>
                <div class="ms-4">
                    <?php
                    $sql3 = "SELECT COUNT(DISTINCT te.corporate_agency_id) AS id
                                FROM employees AS bcm
                                JOIN employees AS bdm 
                                    ON bdm.reporting_manager = bcm.employee_id 
                                AND bdm.user_type = 25
                                JOIN business_mentor AS bm
                                    ON bm.reference_no = bdm.employee_id 
                                AND bm.user_type = 26 
                                AND bm.status = '1'
                                JOIN corporate_agency AS te
                                    ON te.reference_no = bm.business_mentor_id 
                                AND te.status = '1'
                                WHERE bcm.user_type = 24
                                AND bcm.employee_id = :bcm_id";
                    $stmt3 = $conn->prepare($sql3);
                    $stmt3->execute([':bcm_id' => $userId]);
                    $stmt3->setFetchMode(PDO::FETCH_ASSOC);
                    if ($stmt3->rowCount() > 0) {
                        foreach (($stmt3->fetchAll()) as $key => $row) {
                            $id = $row['id'];
                            echo '<h1 class="mb-0 text-white">' . $id . '</h1>';
                        }
                    }
                    ?>
                    <!-- <h1 class="mb-0 text-white">486</h1> -->
                </div>
            </div>
            <div class="d-flex justify-content-between">
                <p class="text-white">This Month</p>
                <?php
                $sql3 = "SELECT COUNT(DISTINCT te.corporate_agency_id) AS id
                                FROM employees AS bcm
                                JOIN employees AS bdm 
                                    ON bdm.reporting_manager = bcm.employee_id 
                                AND bdm.user_type = 25
                                JOIN business_mentor AS bm
                                    ON bm.reference_no = bdm.employee_id 
                                AND bm.user_type = 26 
                                AND bm.status = '1'
                                JOIN corporate_agency AS te
                                    ON te.reference_no = bm.business_mentor_id 
                                AND te.status = '1'
                                WHERE bcm.user_type = 24
                                AND bcm.employee_id = :bcm_id
                                AND YEAR(te.register_date) = :year
                                AND MONTH(te.register_date) = :month";
                $stmt3 = $conn->prepare($sql3);
                $stmt3->execute([
                        ':bcm_id' => $userId,
                        ':year'   => $DateYear,
                        ':month'  => $DateMonth
                    ]);
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
    <!-- F -->
    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-12">
        <div class="card rounded-4 pt-3 pb-2 px-4 cardBg6">
            <div>
                <p class="text-white fw-bold fs-11">Franchisee</p>
            </div>
            <div class="d-flex justify-content-between align-items-center mb-1">
                <span class="">
                    <i class="fa-regular fa-user fa-2xl" style="color: #ffffff;"></i>
                </span>
                <div class="ms-4">
                    <?php
                    $sql3 = "SELECT COUNT(DISTINCT f.sub_franchisee_id) AS id
                                FROM employees AS bcm
                                JOIN employees AS bdm 
                                    ON bdm.reporting_manager = bcm.employee_id 
                                AND bdm.user_type = 25
                                LEFT JOIN master_franchisee AS mf
                                    ON mf.reference_no = bdm.employee_id 
                                AND mf.user_type = 28 
                                AND mf.status = '1'
                                LEFT JOIN sponsor_franchisee AS sf
                                    ON sf.reference_no = bdm.employee_id 
                                AND sf.user_type = 30 
                                AND sf.status = '1'
                                JOIN sub_franchisee AS f
                                    ON (f.reference_no = mf.master_franchisee_id OR f.reference_no = sf.sponsor_franchisee_id)
                                AND f.status = '1'
                                WHERE bcm.user_type = 24
                                AND bcm.employee_id = :bcm_id";
                    $stmt3 = $conn->prepare($sql3);
                    $stmt3->execute([':bcm_id' => $userId]);
                    $stmt3->setFetchMode(PDO::FETCH_ASSOC);
                    if ($stmt3->rowCount() > 0) {
                        foreach (($stmt3->fetchAll()) as $key => $row) {
                            $id = $row['id'];
                            echo '<h1 class="mb-0 text-white">' . $id . '</h1>';
                        }
                    }
                    ?>
                    <!-- <h1 class="mb-0 text-white">486</h1> -->
                </div>
            </div>
            <div class="d-flex justify-content-between">
                <p class="text-white">This Month</p>
                <?php
                $sql3 = "SELECT COUNT(DISTINCT f.sub_franchisee_id) AS id
                                FROM employees AS bcm
                                JOIN employees AS bdm 
                                    ON bdm.reporting_manager = bcm.employee_id 
                                AND bdm.user_type = 25
                                LEFT JOIN master_franchisee AS mf
                                    ON mf.reference_no = bdm.employee_id 
                                AND mf.user_type = 28 
                                AND mf.status = '1'
                                LEFT JOIN sponsor_franchisee AS sf
                                    ON sf.reference_no = bdm.employee_id 
                                AND sf.user_type = 30 
                                AND sf.status = '1'
                                JOIN sub_franchisee AS f
                                    ON (f.reference_no = mf.master_franchisee_id OR f.reference_no = sf.sponsor_franchisee_id)
                                AND f.status = '1'
                                WHERE bcm.user_type = 24
                                AND bcm.employee_id = :bcm_id
                                AND YEAR(f.register_date) = :year
                                AND MONTH(f.register_date) = :month";
                $stmt3 = $conn->prepare($sql3);
                $stmt3->execute([
                        ':bcm_id' => $userId,
                        ':year'   => $DateYear,
                        ':month'  => $DateMonth
                    ]);
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
    <!-- TC -->
    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-12">
        <div class="card rounded-4 pt-3 pb-2 px-4 cardBg7">
            <div>
                <p class="text-white fw-bold fs-11">Travel Consultant</p>
            </div>
            <div class="d-flex justify-content-between align-items-center mb-1">
                <span class="">
                    <i class="fa-regular fa-user fa-2xl" style="color: #ffffff;"></i>
                </span>
                <div class="ms-4">
        
                    <?php
                    // Total TCs 
                    $sql4 = "SELECT COUNT(DISTINCT tc.ca_travelagency_id) AS id
                                FROM employees AS bcm
                                JOIN employees AS bdm 
                                    ON bdm.reporting_manager = bcm.employee_id 
                                AND bdm.user_type = 25
                                LEFT JOIN business_mentor AS bm 
                                    ON bm.reference_no = bdm.employee_id 
                                AND bm.user_type = 26 
                                AND bm.status = '1'
                                LEFT JOIN master_franchisee AS mf 
                                    ON mf.reference_no = bdm.employee_id 
                                AND mf.user_type = 28 
                                AND mf.status = '1'
                                LEFT JOIN sponsor_franchisee AS sf 
                                    ON sf.reference_no = bdm.employee_id 
                                AND sf.user_type = 30 
                                AND sf.status = '1'
                                LEFT JOIN sub_franchisee AS f_direct 
                                    ON f_direct.reference_no = bdm.employee_id 
                                AND f_direct.status = '1'
                                LEFT JOIN sub_franchisee AS f_from_mf 
                                    ON f_from_mf.reference_no = mf.master_franchisee_id 
                                AND f_from_mf.status = '1'
                                LEFT JOIN sub_franchisee AS f_from_sf 
                                    ON f_from_sf.reference_no = sf.sponsor_franchisee_id 
                                AND f_from_sf.status = '1'
                                LEFT JOIN corporate_agency AS te
                                    ON te.reference_no = bdm.employee_id 
                                AND te.status = '1'
                                JOIN ca_travelagency AS tc 
                                    ON tc.status = 1
                                AND (
                                        -- Path 1: BCM → BDM → BM → TC
                                        tc.reference_no = bm.business_mentor_id
                                        OR
                                        -- Path 2: BCM → BDM → F → TC
                                        tc.reference_no = f_direct.sub_franchisee_id
                                        OR
                                        -- Path 3: BCM → BDM → MF → TC
                                        tc.reference_no = mf.master_franchisee_id
                                        OR
                                        -- Path 4: BCM → BDM → SF → F → TC
                                        tc.reference_no = f_from_sf.sub_franchisee_id
                                        OR
                                        -- Path 5: BCM → BDM → MF → F → TC
                                        tc.reference_no = f_from_mf.sub_franchisee_id
                                        OR
                                        -- Path 6: BCM → BDM → TC
                                        tc.reference_no = bdm.employee_id
                                        OR
                                        -- Path 7: BCM → BDM → TE → TC
                                        tc.reference_no = te.corporate_agency_id
                                )
                                WHERE bcm.user_type = 24
                                AND bcm.employee_id = :bcm_id";

                    $stmt4 = $conn->prepare($sql4);
                    $stmt4->execute([':bcm_id' => $userId]);
                    $stmt4->setFetchMode(PDO::FETCH_ASSOC);

                    if ($stmt4->rowCount() > 0) {
                        $row = $stmt4->fetch();
                        echo '<h1 class="mb-0 text-white">' . $row['id'] . '</h1>';
                    }
                    ?>
                </div>
            </div>
            <div class="d-flex justify-content-between">
                <p class="text-white">TC - This Month</p>
                <?php
                // TCs 
                $sql5 = "SELECT COUNT(DISTINCT tc.ca_travelagency_id) AS id
                            FROM employees AS bcm
                            JOIN employees AS bdm 
                                ON bdm.reporting_manager = bcm.employee_id 
                            AND bdm.user_type = 25
                            LEFT JOIN business_mentor AS bm 
                                ON bm.reference_no = bdm.employee_id 
                            AND bm.user_type = 26 
                            AND bm.status = '1'
                            LEFT JOIN master_franchisee AS mf 
                                ON mf.reference_no = bdm.employee_id 
                            AND mf.user_type = 28 
                            AND mf.status = '1'
                            LEFT JOIN sponsor_franchisee AS sf 
                                ON sf.reference_no = bdm.employee_id 
                            AND sf.user_type = 30 
                            AND sf.status = '1'
                            LEFT JOIN sub_franchisee AS f_direct 
                                ON f_direct.reference_no = bdm.employee_id 
                            AND f_direct.status = '1'
                            LEFT JOIN sub_franchisee AS f_from_mf 
                                ON f_from_mf.reference_no = mf.master_franchisee_id 
                            AND f_from_mf.status = '1'
                            LEFT JOIN sub_franchisee AS f_from_sf 
                                ON f_from_sf.reference_no = sf.sponsor_franchisee_id 
                            AND f_from_sf.status = '1'
                            LEFT JOIN corporate_agency AS te
                                ON te.reference_no = bdm.employee_id 
                            AND te.status = '1'
                            JOIN ca_travelagency AS tc 
                                ON tc.status = 1
                            AND (
                                    -- Path 1: BCM → BDM → BM → TC
                                    tc.reference_no = bm.business_mentor_id
                                    OR
                                    -- Path 2: BCM → BDM → F → TC
                                    tc.reference_no = f_direct.sub_franchisee_id
                                    OR
                                    -- Path 3: BCM → BDM → MF → TC
                                    tc.reference_no = mf.master_franchisee_id
                                    OR
                                    -- Path 4: BCM → BDM → SF → F → TC
                                    tc.reference_no = f_from_sf.sub_franchisee_id
                                    OR
                                    -- Path 5: BCM → BDM → MF → F → TC
                                    tc.reference_no = f_from_mf.sub_franchisee_id
                                    OR
                                    -- Path 6: BCM → BDM → TC
                                    tc.reference_no = bdm.employee_id
                                    OR
                                    -- Path 7: BCM → BDM → TE → TC
                                    tc.reference_no = te.corporate_agency_id
                            )
                            WHERE bcm.user_type = 24
                            AND bcm.employee_id = :bcm_id
                            AND YEAR(tc.register_date) = :year
                            AND MONTH(tc.register_date) = :month";

                $stmt5 = $conn->prepare($sql5);
                $stmt5->execute([
                    ':bcm_id' => $userId,
                    ':year'   => $DateYear,
                    ':month'  => $DateMonth
                ]);
                $stmt5->setFetchMode(PDO::FETCH_ASSOC);

                if ($stmt5->rowCount() > 0) {
                    $row = $stmt5->fetch();
                    echo '<p class="text-white">' . $row['id'] . '</p>';
                }
                ?>
            </div>
        </div>
    </div>
    <!-- CU -->
    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-12">
        <div class="card rounded-4 pt-3 pb-2 px-4 cardBg8">
            <div>
                <p class="text-white fw-bold fs-11">Customer</p>
            </div>
            <div class="d-flex justify-content-between align-items-center mb-1">
                <span class="">
                    <i class="fa-regular fa-user fa-2xl" style="color: #ffffff;"></i>
                </span>
                <div class="ms-4">
        
                    <?php
                    // Total CUs 
                    $sql4 = "SELECT COUNT(DISTINCT cu.ca_customer_id) AS id
                                FROM employees AS bcm
                                JOIN employees AS bdm 
                                    ON bdm.reporting_manager = bcm.employee_id 
                                AND bdm.user_type = 25
                                LEFT JOIN business_mentor AS bm 
                                    ON bm.reference_no = bdm.employee_id 
                                AND bm.user_type = 26 
                                AND bm.status = '1'
                                LEFT JOIN master_franchisee AS mf 
                                    ON mf.reference_no = bdm.employee_id 
                                AND mf.user_type = 28 
                                AND mf.status = '1'
                                LEFT JOIN sponsor_franchisee AS sf 
                                    ON sf.reference_no = bdm.employee_id 
                                AND sf.user_type = 30 
                                AND sf.status = '1'
                                LEFT JOIN sub_franchisee AS f_direct 
                                    ON f_direct.reference_no = bdm.employee_id 
                                AND f_direct.status = '1'
                                LEFT JOIN sub_franchisee AS f_from_mf 
                                    ON f_from_mf.reference_no = mf.master_franchisee_id 
                                AND f_from_mf.status = '1'
                                LEFT JOIN sub_franchisee AS f_from_sf 
                                    ON f_from_sf.reference_no = sf.sponsor_franchisee_id 
                                AND f_from_sf.status = '1'
                                JOIN ca_travelagency AS tc 
                                    ON tc.status = 1
                                AND (
                                    -- Path 1: BCM → BDM → BM → TC
                                    tc.reference_no = bm.business_mentor_id
                                    OR
                                    -- Path 2: BCM → BDM → F → TC
                                    tc.reference_no = f_direct.sub_franchisee_id
                                    OR
                                    -- Path 3: BCM → BDM → MF → TC
                                    tc.reference_no = mf.master_franchisee_id
                                    OR
                                    -- Path 4: BCM → BDM → SF → F → TC
                                    tc.reference_no = f_from_sf.sub_franchisee_id
                                    OR
                                    -- Path 5: BCM → BDM → MF → F → TC
                                    tc.reference_no = f_from_mf.sub_franchisee_id
                                    OR
                                    -- Path 6: BCM → BDM → TC
                                    tc.reference_no = bdm.employee_id
                                )
                                JOIN ca_customer AS cu
                                    ON cu.ta_reference_no = tc.ca_travelagency_id
                                WHERE bcm.user_type = 24
                                AND bcm.employee_id = :bcm_id";

                    $stmt4 = $conn->prepare($sql4);
                    $stmt4->execute([':bcm_id' => $userId]);
                    $stmt4->setFetchMode(PDO::FETCH_ASSOC);

                    if ($stmt4->rowCount() > 0) {
                        $row = $stmt4->fetch();
                        echo '<h1 class="mb-0 text-white">' . $row['id'] . '</h1>';
                    }
                    ?>
                </div>
            </div>
            <div class="d-flex justify-content-between">
                <p class="text-white">CU - This Month</p>
                <?php
                // TCs 
                $sql5 = "SELECT COUNT(DISTINCT cu.ca_customer_id) AS id
                            FROM employees AS bcm
                            JOIN employees AS bdm 
                                ON bdm.reporting_manager = bcm.employee_id 
                            AND bdm.user_type = 25
                            LEFT JOIN business_mentor AS bm 
                                ON bm.reference_no = bdm.employee_id 
                            AND bm.user_type = 26 
                            AND bm.status = '1'
                            LEFT JOIN master_franchisee AS mf 
                                ON mf.reference_no = bdm.employee_id 
                            AND mf.user_type = 28 
                            AND mf.status = '1'
                            LEFT JOIN sponsor_franchisee AS sf 
                                ON sf.reference_no = bdm.employee_id 
                            AND sf.user_type = 30 
                            AND sf.status = '1'
                            LEFT JOIN sub_franchisee AS f_direct 
                                ON f_direct.reference_no = bdm.employee_id 
                            AND f_direct.status = '1'
                            LEFT JOIN sub_franchisee AS f_from_mf 
                                ON f_from_mf.reference_no = mf.master_franchisee_id 
                            AND f_from_mf.status = '1'
                            LEFT JOIN sub_franchisee AS f_from_sf 
                                ON f_from_sf.reference_no = sf.sponsor_franchisee_id 
                            AND f_from_sf.status = '1'
                            JOIN ca_travelagency AS tc 
                                ON tc.status = 1
                            AND (
                                -- Path 1: BCM → BDM → BM → TC
                                tc.reference_no = bm.business_mentor_id
                                OR
                                -- Path 2: BCM → BDM → F → TC
                                tc.reference_no = f_direct.sub_franchisee_id
                                OR
                                -- Path 3: BCM → BDM → MF → TC
                                tc.reference_no = mf.master_franchisee_id
                                OR
                                -- Path 4: BCM → BDM → SF → F → TC
                                tc.reference_no = f_from_sf.sub_franchisee_id
                                OR
                                -- Path 5: BCM → BDM → MF → F → TC
                                tc.reference_no = f_from_mf.sub_franchisee_id
                                OR
                                -- Path 6: BCM → BDM → TC
                                tc.reference_no = bdm.employee_id
                            )
                            JOIN ca_customer AS cu
                                ON cu.ta_reference_no = tc.ca_travelagency_id
                            WHERE bcm.user_type = 24
                            AND bcm.employee_id = :bcm_id
                            AND YEAR(tc.register_date) = :year
                            AND MONTH(tc.register_date) = :month";

                $stmt5 = $conn->prepare($sql5);
                $stmt5->execute([
                    ':bcm_id' => $userId,
                    ':year'   => $DateYear,
                    ':month'  => $DateMonth
                ]);
                $stmt5->setFetchMode(PDO::FETCH_ASSOC);

                if ($stmt5->rowCount() > 0) {
                    $row = $stmt5->fetch();
                    echo '<p class="text-white">' . $row['id'] . '</p>';
                }
                ?>
            </div>
        </div>
    </div>
    

</div>
<!-- New Card Template end -->