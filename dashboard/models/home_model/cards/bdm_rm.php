<!-- New Card Template Start -->
<div class="row">
    <?php
        if ($userType == '31') {
    ?>
    <!-- MF -->
    <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12 col-12">
        <div class="card rounded-3 pt-3 pb-2 px-4 cardBg1">
            <div>
                <p class="text-white fw-bold">Master Franchisee</p>
            </div>
            <div class="d-flex justify-content-between align-items-center mb-1">
                <span class="">
                    <i class="fa-regular fa-user fa-2xl" style="color: #ffffff;"></i>
                </span>
                <div class="ms-4">
                    <?php
                    $sql3 = "SELECT COUNT(master_franchisee_id) as id FROM master_franchisee WHERE reference_no = '" . $userId . "' AND user_type = '28' AND status = '1'";
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
                $sql3 = "SELECT COUNT(master_franchisee_id) as id FROM master_franchisee WHERE reference_no = '" . $userId . "' AND user_type = '28' AND YEAR(register_date) = '" . $DateYear . "' AND MONTH(register_date) = '" . $DateMonth . "' AND status = '1'";
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
    <!-- SF -->
    <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12 col-12">
        <div class="card rounded-3 pt-3 pb-2 px-4 cardBg1">
            <div>
                <p class="text-white fw-bold">Sponsor Franchisee</p>
            </div>
            <div class="d-flex justify-content-between align-items-center mb-1">
                <span class="">
                    <i class="fa-regular fa-user fa-2xl" style="color: #ffffff;"></i>
                </span>
                <div class="ms-4">
                    <?php
                    $sql3 = "SELECT COUNT(sponsor_franchisee_id) as id FROM sponsor_franchisee WHERE reference_no = '" . $userId . "' AND user_type = '30' AND status = '1'";
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
                $sql3 = "SELECT COUNT(sponsor_franchisee_id) as id FROM sponsor_franchisee WHERE reference_no = '" . $userId . "' AND user_type = '30' AND YEAR(register_date) = '" . $DateYear . "' AND MONTH(register_date) = '" . $DateMonth . "' AND status = '1'";
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
    <!-- F -->
    <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12 col-12">
        <div class="card rounded-3 pt-3 pb-2 px-4 cardBg2">
            <div>
                <p class="text-white fw-bold">Franchisee</p>
            </div>
            <div class="d-flex justify-content-between align-items-center mb-1">
                <span class="">
                    <i class="fa-regular fa-user fa-2xl" style="color: #ffffff;"></i>
                </span>
                <div class="ms-4">
                    <?php
                    $stmt2 = $conn->prepare("SELECT master_franchisee_id AS id FROM `master_franchisee` WHERE reference_no = ? AND user_type = '28'
                                                UNION
                                                SELECT sponsor_franchisee_id AS id FROM `sponsor_franchisee` WHERE reference_no = ? AND user_type = '30'
                                                UNION
                                                SELECT employee_id AS id FROM `employees` WHERE employee_id = ? AND user_type = '31' ");
                    $stmt2->execute([$userId,$userId,$userId]);
                    $referrals = $stmt2->fetchAll(PDO::FETCH_ASSOC);

                    $count = 0; // Initialize count

                    foreach ($referrals as $referral) {
                        $userBM = $referral['id'];

                        $stmt4 = $conn->prepare("SELECT sub_franchisee_id FROM sub_franchisee WHERE reference_no = ?");
                        $stmt4->execute([$userBM]);
                        $stmt4->setFetchMode(PDO::FETCH_ASSOC);
                        if ($stmt4->rowCount() > 0) {
                            foreach (($stmt4->fetchAll()) as $userTEs => $userTE) {
                                $userTECHNO = $userTE['sub_franchisee_id'] . ' ';
                                $count++; // Increment count for each ca_travelagency_id
                            } //CATA foreach ends
                        } //CATA if loop ends
                    } //CA foreach ends 
                    echo '<h1 class="mb-0 text-white"> ' . $count . '</h1>';
                    ?>
                </div>
            </div>
            <div class="d-flex justify-content-between">
                <p class="text-white">This Month</p>
                <?php
                $stmt2 = $conn->prepare("SELECT master_franchisee_id AS id FROM `master_franchisee` WHERE reference_no = ? AND user_type = '28'
                                            UNION
                                            SELECT sponsor_franchisee_id AS id FROM `sponsor_franchisee` WHERE reference_no = ? AND user_type = '30'
                                            UNION
                                            SELECT employee_id AS id FROM `employees` WHERE employee_id = ? AND user_type = '31'  ");
                $stmt2->execute([$userId,$userId,$userId]);
                $referrals = $stmt2->fetchAll(PDO::FETCH_ASSOC);

                $count = 0; // Initialize count

                foreach ($referrals as $referral) {
                    $userBM = $referral['id'];

                    $stmt4 = $conn->prepare("SELECT sub_franchisee_id FROM sub_franchisee WHERE reference_no = ? AND YEAR(register_date) = '" . $DateYear . "' AND MONTH(register_date) = '" . $DateMonth . "' AND status = '1' ");
                    $stmt4->execute([$userBM]);
                    $stmt4->setFetchMode(PDO::FETCH_ASSOC);
                    if ($stmt4->rowCount() > 0) {
                        foreach (($stmt4->fetchAll()) as $userTEs => $userTE) {
                            $userTECHNO = $userTE['sub_franchisee_id'] . ' ';
                            $count++; // Increment count for each ca_travelagency_id
                        } //CATA foreach ends
                    } //CATA if loop ends
                } //CA foreach ends 
                echo '<p class="text-white"> ' . $count . '</p>';
                ?>
            </div>
        </div>
    </div>
    <?php
        }else{
    ?>
    <!-- BM -->
    <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12 col-12">
        <div class="card rounded-3 pt-3 pb-2 px-4 cardBg1">
            <div>
                <p class="text-white fw-bold">Business Mentor</p>
            </div>
            <div class="d-flex justify-content-between align-items-center mb-1">
                <span class="">
                    <i class="fa-regular fa-user fa-2xl" style="color: #ffffff;"></i>
                </span>
                <div class="ms-4">
                    <?php
                    $sql3 = "SELECT COUNT(business_mentor_id) as id FROM business_mentor WHERE reference_no = '" . $userId . "' AND user_type = '26' AND status = '1'";
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
                $sql3 = "SELECT COUNT(business_mentor_id) as id FROM business_mentor WHERE reference_no = '" . $userId . "' AND user_type = '26' AND YEAR(register_date) = '" . $DateYear . "' AND MONTH(register_date) = '" . $DateMonth . "' AND status = '1'";
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
    <!-- MF -->
    <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12 col-12">
        <div class="card rounded-3 pt-3 pb-2 px-4 cardBg2">
            <div>
                <p class="text-white fw-bold">Master Franchisee</p>
            </div>
            <div class="d-flex justify-content-between align-items-center mb-1">
                <span class="">
                    <i class="fa-regular fa-user fa-2xl" style="color: #ffffff;"></i>
                </span>
                <div class="ms-4">
                    <?php
                    $sql3 = "SELECT COUNT(master_franchisee_id) as id FROM master_franchisee WHERE reference_no = '" . $userId . "' AND user_type = '28' AND status = '1'";
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
                $sql3 = "SELECT COUNT(master_franchisee_id) as id FROM master_franchisee WHERE reference_no = '" . $userId . "' AND user_type = '28' AND YEAR(register_date) = '" . $DateYear . "' AND MONTH(register_date) = '" . $DateMonth . "' AND status = '1'";
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
    <!-- SF -->
    <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12 col-12">
        <div class="card rounded-3 pt-3 pb-2 px-4 cardBg3">
            <div>
                <p class="text-white fw-bold">Sponsor Franchisee</p>
            </div>
            <div class="d-flex justify-content-between align-items-center mb-1">
                <span class="">
                    <i class="fa-regular fa-user fa-2xl" style="color: #ffffff;"></i>
                </span>
                <div class="ms-4">
                    <?php
                    $sql3 = "SELECT COUNT(sponsor_franchisee_id) as id FROM sponsor_franchisee WHERE reference_no = '" . $userId . "' AND user_type = '30' AND status = '1'";
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
                $sql3 = "SELECT COUNT(sponsor_franchisee_id) AS id 
                        FROM sponsor_franchisee 
                        WHERE reference_no = :userId 
                        AND user_type = '30' 
                        AND YEAR(register_date) = :year 
                        AND MONTH(register_date) = :month 
                        AND status = '1'";

                $stmt3 = $conn->prepare($sql3);
                $stmt3->execute([
                    ':userId' => $userId,
                    ':year'   => $DateYear,
                    ':month'  => $DateMonth
                ]);
                $stmt3->setFetchMode(PDO::FETCH_ASSOC);

                if ($stmt3->rowCount() > 0) {
                    foreach ($stmt3->fetchAll() as $row) {
                        $id = $row['id'];
                        echo '<p class="text-white">' . $id . '</p>';
                    }
                }
                ?>

            </div>
        </div>
    </div>
    <!-- F -->
    <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12 col-12">
        <div class="card rounded-3 pt-3 pb-2 px-4 cardBg4">
            <div>
                <p class="text-white fw-bold">Franchisee</p>
            </div>
            <div class="d-flex justify-content-between align-items-center mb-1">
                <span class="">
                    <i class="fa-regular fa-user fa-2xl" style="color: #ffffff;"></i>
                </span>
                <div class="ms-4">
                    <?php
                    $stmt2 = $conn->prepare("SELECT master_franchisee_id AS id FROM `master_franchisee` WHERE reference_no = ? AND user_type = '28' AND status='1'
                                                UNION
                                                SELECT sponsor_franchisee_id AS id FROM `sponsor_franchisee` WHERE reference_no = ? AND user_type = '30' AND status='1' 
                                                UNION
                                                SELECT employee_id AS id FROM employees WHERE employee_id =? AND user_type='25' AND status='1'");
                    $stmt2->execute([$userId,$userId,$userId]);
                    $referrals = $stmt2->fetchAll(PDO::FETCH_ASSOC);

                    $count = 0; // Initialize count

                    foreach ($referrals as $referral) {
                        $userBM = $referral['id'];

                        $stmt4 = $conn->prepare("SELECT sub_franchisee_id FROM sub_franchisee WHERE reference_no = ? AND status='1'");
                        $stmt4->execute([$userBM]);
                        $stmt4->setFetchMode(PDO::FETCH_ASSOC);
                        if ($stmt4->rowCount() > 0) {
                            foreach (($stmt4->fetchAll()) as $userTEs => $userTE) {
                                $userTECHNO = $userTE['sub_franchisee_id'] . ' ';
                                $count++; // Increment count for each ca_travelagency_id
                            } //CATA foreach ends
                        } //CATA if loop ends
                    } //CA foreach ends 
                    echo '<h1 class="mb-0 text-white"> ' . $count . '</h1>';
                    ?>
                </div>
            </div>
            <div class="d-flex justify-content-between">
                <p class="text-white">This Month</p>
                <?php
                $stmt2 = $conn->prepare("SELECT master_franchisee_id AS id FROM `master_franchisee` WHERE reference_no = ? AND user_type = '28' AND status='1'
                                            UNION
                                            SELECT sponsor_franchisee_id AS id FROM `sponsor_franchisee` WHERE reference_no = ? AND user_type = '30' AND status='1' 
                                            UNION
                                            SELECT employee_id AS id FROM employees WHERE employee_id =? AND user_type='25' AND status='1'");
                $stmt2->execute([$userId,$userId,$userId]);
                $referrals = $stmt2->fetchAll(PDO::FETCH_ASSOC);

                $count = 0; // Initialize count

                foreach ($referrals as $referral) {
                    $userBM = $referral['id'];

                    $stmt4 = $conn->prepare("SELECT sub_franchisee_id FROM sub_franchisee WHERE reference_no = ? AND YEAR(register_date) = '" . $DateYear . "' AND MONTH(register_date) = '" . $DateMonth . "' AND status = '1' ");
                    $stmt4->execute([$userBM]);
                    $stmt4->setFetchMode(PDO::FETCH_ASSOC);
                    if ($stmt4->rowCount() > 0) {
                        foreach (($stmt4->fetchAll()) as $userTEs => $userTE) {
                            $userTECHNO = $userTE['sub_franchisee_id'] . ' ';
                            $count++; // Increment count for each ca_travelagency_id
                        } //CATA foreach ends
                    } //CATA if loop ends
                } //CA foreach ends 
                echo '<p class="text-white"> ' . $count . '</p>';
                ?>
            </div>
        </div>
    </div>
    <!-- TE -->
    <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12 col-12">
        <div class="card rounded-3 pt-3 pb-2 px-4 cardBg5">
            <div>
                <p class="text-white fw-bold">Techno Enterprise</p>
            </div>
            <div class="d-flex justify-content-between align-items-center mb-1">
                <span class="">
                    <i class="fa-regular fa-user fa-2xl" style="color: #ffffff;"></i>
                </span>
                <div class="ms-4">
                    <?php
                    $count = 0;

                    // 1. Get BMs under this user
                    $stmt2 = $conn->prepare("SELECT business_mentor_id 
                                            FROM business_mentor 
                                            WHERE reference_no = ? AND user_type = '26' AND status='1'");
                    $stmt2->execute([$userId]);
                    $bmIds = $stmt2->fetchAll(PDO::FETCH_COLUMN); // Just BM IDs

                    // 2. Get TEs under all BMs
                    if (!empty($bmIds)) {
                        $inClause = implode(',', array_fill(0, count($bmIds), '?'));
                        $stmt4 = $conn->prepare("SELECT corporate_agency_id 
                                                FROM corporate_agency 
                                                WHERE reference_no IN ($inClause) AND status='1'");
                        $stmt4->execute($bmIds);
                        $count += $stmt4->rowCount();
                    }

                    // 3. Get direct TEs
                    $stmt4 = $conn->prepare("SELECT corporate_agency_id 
                                            FROM corporate_agency 
                                            WHERE reference_no = ? AND status='1'");
                    $stmt4->execute([$userId]);
                    $count += $stmt4->rowCount();

                    
                    echo '<h1 class="mb-0 text-white"> ' . $count . '</h1>';
                    ?>
                </div>
            </div>
            <div class="d-flex justify-content-between">
                <p class="text-white">This Month</p>
                <?php
                    $count = 0;

                    // 1. Get BMs referred by user
                    $stmt2 = $conn->prepare("
                        SELECT business_mentor_id 
                        FROM business_mentor 
                        WHERE reference_no = ? AND user_type = '26'
                    ");
                    $stmt2->execute([$userId]);
                    $referrals = $stmt2->fetchAll(PDO::FETCH_ASSOC);

                    // 2. Loop over BMs and count their direct TEs
                    foreach ($referrals as $referral) {
                        $userBM = $referral['business_mentor_id'];

                        $stmt4 = $conn->prepare("
                            SELECT COUNT(*) AS total 
                            FROM corporate_agency 
                            WHERE reference_no = ? 
                            AND YEAR(register_date) = ? 
                            AND MONTH(register_date) = ? 
                            AND status = '1'
                        ");
                        $stmt4->execute([$userBM, $DateYear, $DateMonth]);
                        $row = $stmt4->fetch(PDO::FETCH_ASSOC);
                        $count += $row['total'];
                    }

                    // 3. Direct TEs of this user
                    $stmt4 = $conn->prepare("
                        SELECT COUNT(*) AS total 
                        FROM corporate_agency 
                        WHERE reference_no = ? 
                        AND YEAR(register_date) = ? 
                        AND MONTH(register_date) = ? 
                        AND status = '1'
                    ");
                    $stmt4->execute([$userId, $DateYear, $DateMonth]);
                    $row = $stmt4->fetch(PDO::FETCH_ASSOC);
                    $count += $row['total'];

                echo '<p class="text-white"> ' . $count . '</p>';
                ?>
            </div>
        </div>
    </div>
    <!-- I -->
    <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12 col-12">
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
                    $count = 0;

                    // 1. Get BMs under this user
                    $stmt2 = $conn->prepare("SELECT business_mentor_id 
                                            FROM business_mentor 
                                            WHERE reference_no = ? AND user_type = '26' AND status='1'");
                    $stmt2->execute([$userId]);
                    $bmIds = $stmt2->fetchAll(PDO::FETCH_COLUMN); // Just BM IDs

                    // 2. Get TEs under all BMs
                    if (!empty($bmIds)) {
                        $inClause = implode(',', array_fill(0, count($bmIds), '?'));
                        $stmt4 = $conn->prepare("SELECT institution_id 
                                                FROM institution 
                                                WHERE reference_no IN ($inClause) AND status='1'");
                        $stmt4->execute($bmIds);
                        $count += $stmt4->rowCount();
                    }

                    // 3. Get direct TEs
                    $stmt4 = $conn->prepare("SELECT institution_id 
                                            FROM institution 
                                            WHERE reference_no = ? AND status='1'");
                    $stmt4->execute([$userId]);
                    $count += $stmt4->rowCount();
                    echo '<h1 class="mb-0 text-white"> ' . $count . '</h1>';
                    ?>
                </div>
            </div>
            <div class="d-flex justify-content-between">
                <p class="text-white">This Month</p>
                <?php
                    $count = 0;

                    // 1. Get BMs referred by user
                    $stmt2 = $conn->prepare("
                        SELECT business_mentor_id 
                        FROM business_mentor 
                        WHERE reference_no = ? AND user_type = '26'
                    ");
                    $stmt2->execute([$userId]);
                    $referrals = $stmt2->fetchAll(PDO::FETCH_ASSOC);

                    // 2. Loop over BMs and count their direct TEs
                    foreach ($referrals as $referral) {
                        $userBM = $referral['business_mentor_id'];

                        $stmt4 = $conn->prepare("
                            SELECT COUNT(*) AS total 
                            FROM institution 
                            WHERE reference_no = ? 
                            AND YEAR(register_date) = ? 
                            AND MONTH(register_date) = ? 
                            AND status = '1'
                        ");
                        $stmt4->execute([$userBM, $DateYear, $DateMonth]);
                        $row = $stmt4->fetch(PDO::FETCH_ASSOC);
                        $count += $row['total'];
                    }

                    // 4. Direct Institution of this user
                    $stmt4 = $conn->prepare("
                        SELECT COUNT(*) AS total 
                        FROM institution 
                        WHERE reference_no = ? 
                        AND YEAR(register_date) = ? 
                        AND MONTH(register_date) = ? 
                        AND status = '1'
                    ");
                    $stmt4->execute([$userId, $DateYear, $DateMonth]);
                    $row = $stmt4->fetch(PDO::FETCH_ASSOC);
                    $count += $row['total'];

                echo '<p class="text-white"> ' . $count . '</p>';
                ?>
            </div>
        </div>
    </div>
    <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-12">
        <div class="card rounded-3 pt-3 pb-2 px-4 cardBg6">
            <div>
                <p class="text-white fw-bold fs-11">Institution Branch Manager</p>
            </div>
            <div class="d-flex justify-content-between align-items-center mb-1">
                <span class="">
                    <i class="fa-regular fa-user fa-2xl" style="color: #ffffff;"></i>
                </span>
                <div class="ms-4">
        
                    <?php
                    // Total TCs 
                    $sql4 = "SELECT COUNT(DISTINCT tc.institution_branch_manager_id) AS id
                                FROM employees AS bdm
                                LEFT JOIN business_mentor AS bm 
                                    ON bm.reference_no = bdm.employee_id 
                                AND bm.user_type = 26 
                                AND bm.status = '1'
                                LEFT JOIN institution AS i_direct 
                                    ON i_direct.reference_no = bdm.employee_id 
                                AND i_direct.user_type = 26 
                                AND i_direct.status = '1'
                                JOIN institution_branch_manager AS tc 
                                    ON tc.status = 1
                                AND (
                                    -- Path 1: BDM → BM → IBR
                                    tc.reference_no = bm.business_mentor_id
                                    OR
                                    tc.reference_no = i_direct.institution_id
                                    
                                )
                                WHERE bdm.user_type = 25
                                AND bdm.employee_id = :bdm_id";

                    $stmt4 = $conn->prepare($sql4);
                    $stmt4->execute([':bdm_id' => $userId]);
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
                $sql5 = "SELECT COUNT(DISTINCT tc.institution_branch_manager_id) AS id
                            FROM employees AS bdm
                            LEFT JOIN business_mentor AS bm 
                                ON bm.reference_no = bdm.employee_id 
                            AND bm.user_type = 26 
                            AND bm.status = '1'
                            LEFT JOIN institution AS i_direct 
                                ON i_direct.reference_no = bdm.employee_id 
                            AND i_direct.user_type = 26 
                            AND i_direct.status = '1'
                            JOIN institution_branch_manager AS tc 
                                ON tc.status = 1
                            AND (
                                -- Path 1: BDM → BM → IBR
                                tc.reference_no = bm.business_mentor_id
                                OR
                                tc.reference_no = i_direct.institution_id
                                
                            )
                            WHERE bdm.user_type = 25
                            AND bdm.employee_id = :bdm_id
                            AND YEAR(tc.register_date) = :year
                            AND MONTH(tc.register_date) = :month";

                $stmt5 = $conn->prepare($sql5);
                $stmt5->execute([
                    ':bdm_id' => $userId,
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
    <?php
        }
    ?>
    
    <!-- TC -->
    <div class="<?=$userType == '25'?'col-xl-4':'col-xl-6'?> col-lg-6 col-md-6 col-sm-6 col-12">
        <div class="card rounded-3 pt-3 pb-2 px-4 <?=$userType == '25'?'cardBg6':'cardBg4'?>">
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
                                FROM employees AS bdm
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
                                    -- Path 1: BDM → BM → TC
                                    tc.reference_no = bm.business_mentor_id
                                    OR
                                    -- Path 2: BDM → F → TC
                                    tc.reference_no = f_direct.sub_franchisee_id
                                    OR
                                    -- Path 3: BDM → MF → TC
                                    tc.reference_no = mf.master_franchisee_id
                                    OR
                                    -- Path 4: BDM → SF → F → TC
                                    tc.reference_no = f_from_sf.sub_franchisee_id
                                    OR
                                    -- Path 5: BDM → MF → F → TC
                                    tc.reference_no = f_from_mf.sub_franchisee_id
                                    OR
                                    -- Path 6: BDM → TC
                                    tc.reference_no = bdm.employee_id
                                )
                                WHERE bdm.user_type = 25
                                AND bdm.employee_id = :bdm_id";

                    $stmt4 = $conn->prepare($sql4);
                    $stmt4->execute([':bdm_id' => $userId]);
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
                            FROM employees AS bdm
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
                                -- Path 1: BDM → BM → TC
                                tc.reference_no = bm.business_mentor_id
                                OR
                                -- Path 2: BDM → F → TC
                                tc.reference_no = f_direct.sub_franchisee_id
                                OR
                                -- Path 3: BDM → MF → TC
                                tc.reference_no = mf.master_franchisee_id
                                OR
                                -- Path 4: BDM → SF → F → TC
                                tc.reference_no = f_from_sf.sub_franchisee_id
                                OR
                                -- Path 5: BDM → MF → F → TC
                                tc.reference_no = f_from_mf.sub_franchisee_id
                                OR
                                -- Path 6: BDM → TC
                                tc.reference_no = bdm.employee_id
                            )
                            WHERE bdm.user_type = 25
                            AND bdm.employee_id = :bdm_id
                            AND YEAR(tc.register_date) = :year
                            AND MONTH(tc.register_date) = :month";

                $stmt5 = $conn->prepare($sql5);
                $stmt5->execute([
                    ':bdm_id' => $userId,
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
    <div class="<?=$userType == '25'?'col-xl-4':'col-xl-6'?> col-lg-6 col-md-6 col-sm-6 col-12">
        <div class="card rounded-3 pt-3 pb-2 px-4 <?=$userType == '25'?'cardBg7':'cardBg5'?>">
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
                    $sql4 = "   SELECT COUNT(DISTINCT cu.ca_customer_id) AS id
                                FROM employees AS bdm

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

                                --  Institution joins
                                LEFT JOIN institution AS i_direct
                                    ON i_direct.reference_no = bdm.employee_id
                                    AND i_direct.status = '1'

                                LEFT JOIN institution AS i_from_bm
                                    ON i_from_bm.reference_no = bm.business_mentor_id
                                    AND i_from_bm.status = '1'

                                --  IBR joins
                                LEFT JOIN institution_branch_manager AS ibm_direct
                                    ON ibm_direct.reference_no = i_direct.institution_id
                                    AND ibm_direct.status = '1'

                                LEFT JOIN institution_branch_manager AS ibm_from_bm
                                    ON ibm_from_bm.reference_no = i_from_bm.institution_id
                                    AND ibm_from_bm.status = '1'

                                --  Customer JOIN (MUST come before using cu)
                                JOIN ca_customer AS cu 
                                    ON cu.status=1
                                --  IMPORTANT: BOTH TC + IBR (parallel level)
                                LEFT JOIN ca_travelagency AS tc 
                                    ON tc.ca_travelagency_id = cu.ta_reference_no
                                    AND tc.status = 1

                                LEFT JOIN institution_branch_manager AS ibm
                                    ON ibm.institution_branch_manager_id = cu.ta_reference_no
                                    AND ibm.status = 1

                                

                                WHERE bdm.user_type = 25
                                AND bdm.employee_id = :bdm_id

                                AND (
                                    -- BDM direct
                                    COALESCE(tc.reference_no, ibm.reference_no) = bdm.employee_id

                                    -- BDM → BM
                                    OR COALESCE(tc.reference_no, ibm.reference_no) = bm.business_mentor_id

                                    -- BDM → F
                                    OR COALESCE(tc.reference_no, ibm.reference_no) = f_direct.sub_franchisee_id

                                    -- BDM → MF
                                    OR COALESCE(tc.reference_no, ibm.reference_no) = mf.master_franchisee_id

                                    -- BDM → MF → F
                                    OR COALESCE(tc.reference_no, ibm.reference_no) = f_from_mf.sub_franchisee_id

                                    -- BDM → SF → F
                                    OR COALESCE(tc.reference_no, ibm.reference_no) = f_from_sf.sub_franchisee_id

                                    -- BDM → I → IBR
                                    OR COALESCE(tc.reference_no, ibm.reference_no) = ibm_direct.institution_branch_manager_id

                                    -- BDM → BM → I → IBR
                                    OR COALESCE(tc.reference_no, ibm.reference_no) = ibm_from_bm.institution_branch_manager_id
                                )";

                    $stmt4 = $conn->prepare($sql4);
                    $stmt4->execute([':bdm_id' => $userId]);
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
                                FROM employees AS bdm

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

                                --  Institution joins
                                LEFT JOIN institution AS i_direct
                                    ON i_direct.reference_no = bdm.employee_id
                                    AND i_direct.status = '1'

                                LEFT JOIN institution AS i_from_bm
                                    ON i_from_bm.reference_no = bm.business_mentor_id
                                    AND i_from_bm.status = '1'

                                --  IBR joins
                                LEFT JOIN institution_branch_manager AS ibm_direct
                                    ON ibm_direct.reference_no = i_direct.institution_id
                                    AND ibm_direct.status = '1'

                                LEFT JOIN institution_branch_manager AS ibm_from_bm
                                    ON ibm_from_bm.reference_no = i_from_bm.institution_id
                                    AND ibm_from_bm.status = '1'
                                --  Customer JOIN (MUST come before using cu)
                                JOIN ca_customer AS cu 
                                    ON cu.status=1
                                --  IMPORTANT: BOTH TC + IBR (parallel level)
                                LEFT JOIN ca_travelagency AS tc 
                                    ON tc.ca_travelagency_id = cu.ta_reference_no
                                    AND tc.status = 1

                                LEFT JOIN institution_branch_manager AS ibm
                                    ON ibm.institution_branch_manager_id = cu.ta_reference_no
                                    AND ibm.status = 1

                                WHERE bdm.user_type = 25
                                AND bdm.employee_id = :bdm_id

                                AND (
                                    -- BDM direct
                                    COALESCE(tc.reference_no, ibm.reference_no) = bdm.employee_id

                                    -- BDM → BM
                                    OR COALESCE(tc.reference_no, ibm.reference_no) = bm.business_mentor_id

                                    -- BDM → F
                                    OR COALESCE(tc.reference_no, ibm.reference_no) = f_direct.sub_franchisee_id

                                    -- BDM → MF
                                    OR COALESCE(tc.reference_no, ibm.reference_no) = mf.master_franchisee_id

                                    -- BDM → MF → F
                                    OR COALESCE(tc.reference_no, ibm.reference_no) = f_from_mf.sub_franchisee_id

                                    -- BDM → SF → F
                                    OR COALESCE(tc.reference_no, ibm.reference_no) = f_from_sf.sub_franchisee_id

                                    -- BDM → I → IBR
                                    OR COALESCE(tc.reference_no, ibm.reference_no) = ibm_direct.institution_branch_manager_id

                                    -- BDM → BM → I → IBR
                                    OR COALESCE(tc.reference_no, ibm.reference_no) = ibm_from_bm.institution_branch_manager_id
                                )
                            AND YEAR(COALESCE(tc.register_date,ibm.register_date)) = :year
                            AND MONTH(COALESCE(tc.register_date,ibm.register_date)) = :month";

                $stmt5 = $conn->prepare($sql5);
                $stmt5->execute([
                    ':bdm_id' => $userId,
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