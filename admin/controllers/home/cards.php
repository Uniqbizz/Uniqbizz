<div class="row">
    <div class="col-xl-4">
        <div class="card overflow-hidden rounded-4">
            <div class="bg-primary-subtle">
                <div class="row">
                    <div class="col-7 pe-0">
                        <div class="p-3 pb-4">
                            <h5 class="text-primary">Welcome Back !</h5>
                            <p class="text-primary">Admin</p>
                        </div>
                    </div>
                    <div class="col-5 align-self-end">
                        <!-- <img src="../../assets/images/profile-img.png" alt="" class="img-fluid"> -->
                        <div class="avatar-lg mb-2 mt-2">
                            <img src="../../assets/images/users/avatar-1.jpg" alt="" class="img-thumbnail rounded-circle">
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body pt-0">
                <div class="row">
                    <!-- <div class="col-sm-4 col-4"> -->
                        <!-- <div class="avatar-lg mb-3 mt-n5">
                            <img src="../../assets/images/users/avatar-1.jpg" alt="" class="img-thumbnail rounded-circle">
                        </div> -->
                        <!-- <h5 class="font-size-14 text-truncate fw-bolder">Admin</h5> -->
                    <!-- </div> -->

                    <div class="col-sm-12 col-12">
                        <div class="pt-4">
                            <div class="row">
                                <div class="col-7 p-0">
                                    <p class="text-muted font-size-13 ps-2">Packages Sold</p>
                                    <p class="text-muted font-size-13 ps-2">Techno Enterprise</p>
                                    <p class="text-muted font-size-13 ps-2">Franchise</p>
                                    <p class="text-muted font-size-13 ps-2">Master Franchise</p>
                                    <p class="text-muted font-size-13 ps-2">Sponsor Franchise</p>
                                </div>
                                <div class="col-5 p-0">
                                    <!-- Packages Sold  -->
                                    <?php
                                        $sqlbooking = "SELECT COUNT(id) AS booked FROM `bookings` WHERE confirm_status = '1' ";
                                        $sqlBooked = $conn->prepare($sqlbooking);
                                        $sqlBooked->execute();
                                        $sqlBooked->setFetchMode(PDO::FETCH_ASSOC);
                                        if (($sqlBooked->rowCount() > 0)) {
                                            foreach ($sqlBooked->fetchAll() as $key => $value) {
                                                $totalBooked = $value['booked'];
                                                echo '<h5 class="font-size-13">' . $totalBooked . '</h5>';
                                            }
                                        }
                                    ?>
                                    <!-- Techno Enterprise -->
                                    <?php
                                        $Amt = 0;

                                        // Prepare and execute query
                                        $sql = "SELECT SUM(CASE WHEN amount IS NULL THEN 0 ELSE amount END) AS total_amount FROM corporate_agency WHERE status = '1'";
                                        $stmt = $conn->prepare($sql);
                                        $stmt->execute();
                                        $result = $stmt->fetch(PDO::FETCH_ASSOC);

                                        // Fetch total amount
                                        $Amt = $result['total_amount'] ?? 0;

                                        // Format in Indian currency style (e.g., 12,34,567)
                                        $formattedAmt = preg_replace("/(\d+?)(?=(\d\d)+(\d)(?!\d))(\.\d+)?/i", "$1,", $Amt);

                                        // Output
                                        echo '<h5 class="font-size-13"><span>&#8377;</span>' . $formattedAmt . '/-</h5>';
                                    ?>

                                    <!-- sub_franchisee -->
                                    <?php
                                        $Amt = 0;

                                        // Prepare and execute query
                                        $sql = "SELECT SUM(CASE WHEN amount IS NULL THEN 0 ELSE amount END) AS total_amount FROM sub_franchisee WHERE status = '1'";
                                        $stmt = $conn->prepare($sql);
                                        $stmt->execute();
                                        $result = $stmt->fetch(PDO::FETCH_ASSOC);

                                        // Fetch total amount
                                        $Amt = $result['total_amount'] ?? 0;

                                        // Format in Indian currency style (e.g., 12,34,567)
                                        $formattedAmt = preg_replace("/(\d+?)(?=(\d\d)+(\d)(?!\d))(\.\d+)?/i", "$1,", $Amt);

                                        // Output
                                        echo '<h5 class="font-size-13"><span>&#8377;</span>' . $formattedAmt . '/-</h5>';
                                    ?>

                                    <!-- Master Franchisee -->
                                    <?php
                                        $Amt = 0;

                                        // Prepare and execute query
                                        $sql = "SELECT SUM(CASE WHEN paid_amount IS NULL THEN 0 ELSE paid_amount END) AS total_amount FROM master_franchisee WHERE status = '1'";
                                        $stmt = $conn->prepare($sql);
                                        $stmt->execute();
                                        $result = $stmt->fetch(PDO::FETCH_ASSOC);

                                        // Fetch total amount
                                        $Amt = $result['total_amount'] ?? 0;

                                        // Format in Indian currency style (e.g., 12,34,567)
                                        $formattedAmt = preg_replace("/(\d+?)(?=(\d\d)+(\d)(?!\d))(\.\d+)?/i", "$1,", $Amt);

                                        // Output
                                        echo '<h5 class="font-size-13"><span>&#8377;</span>' . $formattedAmt . '/-</h5>';
                                    ?>

                                    <!-- Sponsor Franchise -->
                                    <?php
                                        $Amt = 0;

                                        // Prepare and execute query
                                        $sql = "SELECT SUM(CASE WHEN paid_amount IS NULL THEN 0 ELSE paid_amount END) AS total_amount FROM sponsor_franchisee WHERE status = '1'";
                                        $stmt = $conn->prepare($sql);
                                        $stmt->execute();
                                        $result = $stmt->fetch(PDO::FETCH_ASSOC);

                                        // Fetch total amount
                                        $Amt = $result['total_amount'] ?? 0;

                                        // Format in Indian currency style (e.g., 12,34,567)
                                        $formattedAmt = preg_replace("/(\d+?)(?=(\d\d)+(\d)(?!\d))(\.\d+)?/i", "$1,", $Amt);

                                        // Output
                                        echo '<h5 class="font-size-13"><span>&#8377;</span>' . $formattedAmt . '/-</h5>';
                                    ?>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-8 d-flex align-items-center">
        <div class="row">
            <div class="col-md-4 col-sm-6 col-12">
                <div class="card card-equal mini-stats-wid rounded-4">
                    <div class="card-body">
                        <div class="d-flex">
                            <div class="flex-grow-1">
                                <p class="text-muted fw-medium">Employees</p>
                                <?php
                                    $stmt = $conn->prepare("SELECT COUNT(employee_id) as totalemployee FROM `employees` WHERE  status = '1' ");
                                    $stmt->execute();
                                    $stmt->setFetchMode(PDO::FETCH_ASSOC);
                                    if ($stmt->rowCount() > 0) {
                                        foreach (($stmt->fetchAll()) as $key => $row) {
                                            $totalemployee = $row['totalemployee'];
                                            echo '<h4 class="mb-0">' . $totalemployee . '</h4>';
                                        }
                                    } else {
                                        echo '<h4 class="mb-0">0</h4>';
                                    }
                                ?>
                            </div>

                            <div class="flex-shrink-0">
                                <div class="mini-stat-icon avatar-sm rounded-circle bg-primary">
                                    <span class="avatar-title">
                                        <i class="fas fa-user-alt font-size-24"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4 col-sm-6 col-12">
                <div class="card card-equal mini-stats-wid rounded-4">
                    <div class="card-body">
                        <div class="d-flex">
                            <div class="flex-grow-1">
                                <p class="text-muted fw-medium">Business Mentor</p>
                                <?php
                                    $stmt = $conn->prepare("SELECT count(business_mentor_id) as totalbusiness_mentor FROM business_mentor where user_type='26' and status='1' ");
                                    $stmt->execute();
                                    $stmt->setFetchMode(PDO::FETCH_ASSOC);
                                    if ($stmt->rowCount() > 0) {
                                        foreach (($stmt->fetchAll()) as $key => $row) {
                                            $totalbusiness_mentor = $row['totalbusiness_mentor'];
                                            echo '<h4 class="mb-0">' . $totalbusiness_mentor . '</h4>';
                                        }
                                    } else {
                                        echo '<h4 class="mb-0">0</h4>';
                                    }
                                ?>
                            </div>

                            <div class="flex-shrink-0">
                                <div class="mini-stat-icon avatar-sm rounded-circle bg-primary">
                                    <span class="avatar-title">
                                        <i class="fas fa-user-alt font-size-24"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4 col-sm-6 col-12" style="display: none;">
                <div class="card card-equal mini-stats-wid rounded-4">
                    <div class="card-body">
                        <div class="d-flex">
                            <div class="flex-grow-1">
                                <p class="text-muted fw-medium">Business Trainee</p>
                                <?php
                                    $stmt = $conn->prepare("SELECT count(business_trainee_id) as totalbusiness_trainee FROM business_trainee where user_type='15' and status='1' ");
                                    $stmt->execute();
                                    $stmt->setFetchMode(PDO::FETCH_ASSOC);
                                    if ($stmt->rowCount() > 0) {
                                        foreach (($stmt->fetchAll()) as $key => $row) {
                                            $totalbusiness_trainee = $row['totalbusiness_trainee'];
                                            echo '<h4 class="mb-0">' . $totalbusiness_trainee . '</h4>';
                                        }
                                    } else {
                                        echo '<h4 class="mb-0">0</h4>';
                                    }
                                ?>
                            </div>

                            <div class="flex-shrink-0">
                                <div class="mini-stat-icon avatar-sm rounded-circle bg-primary">
                                    <span class="avatar-title">
                                        <i class="fas fa-user-alt font-size-24"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4 col-sm-6 col-12" style="display: none;">
                <div class="card card-equal mini-stats-wid rounded-4">
                    <div class="card-body">
                        <div class="d-flex">
                            <div class="flex-grow-1">
                                <p class="text-muted fw-medium">Business Consultant</p>
                                <?php
                                    $stmt = $conn->prepare("SELECT count(business_consultant_id) as totalbusiness_consultant FROM business_consultant where user_type='3' and status='1' ");
                                    $stmt->execute();
                                    $stmt->setFetchMode(PDO::FETCH_ASSOC);
                                    if ($stmt->rowCount() > 0) {
                                        foreach (($stmt->fetchAll()) as $key => $row) {
                                            $totalbusiness_consultant = $row['totalbusiness_consultant'];
                                            echo '<h4 class="mb-0">' . $totalbusiness_consultant . '</h4>';
                                        }
                                    } else {
                                        echo '<h4 class="mb-0">0</h4>';
                                    }
                                ?>
                            </div>

                            <div class="flex-shrink-0">
                                <div class="mini-stat-icon avatar-sm rounded-circle bg-primary">
                                    <span class="avatar-title">
                                        <i class="fas fa-user-alt font-size-24"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- TE -->
            <div class="col-md-4 col-sm-6 col-12">
                <div class="card card-equal mini-stats-wid rounded-4">
                    <div class="card-body">
                        <div class="d-flex">
                            <div class="flex-grow-1">
                                <p class="text-muted fw-medium">Techno Enterprise</p>
                                <?php
                                    $stmt = $conn->prepare("SELECT count(corporate_agency_id) as totalcorporate_agency FROM corporate_agency where user_type='16' and status='1' ");
                                    $stmt->execute();
                                    $stmt->setFetchMode(PDO::FETCH_ASSOC);
                                    if ($stmt->rowCount() > 0) {
                                        foreach (($stmt->fetchAll()) as $key => $row) {
                                            $totalcorporate_agency = $row['totalcorporate_agency'];
                                            echo '<h4 class="mb-0">' . $totalcorporate_agency . '</h4>';
                                        }
                                    } else {
                                        echo '<h4 class="mb-0">0</h4>';
                                    }
                                ?>
                            </div>

                            <div class="flex-shrink-0">
                                <div class="mini-stat-icon avatar-sm rounded-circle bg-primary">
                                    <span class="avatar-title">
                                        <i class="fas fa-user-alt font-size-24"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- TC -->
            <div class="col-md-4 col-sm-6 col-12">
                <div class="card card-equal mini-stats-wid rounded-4">
                    <div class="card-body">
                        <div class="d-flex">
                            <div class="flex-grow-1">
                                <p class="text-muted fw-medium">Travel Consultant</p>
                                <?php
                                    $stmt = $conn->prepare("SELECT count(ca_travelagency_id) as totalca_travelagency FROM ca_travelagency where user_type='11' and status='1' ");
                                    $stmt->execute();
                                    $stmt->setFetchMode(PDO::FETCH_ASSOC);
                                    if ($stmt->rowCount() > 0) {
                                        foreach (($stmt->fetchAll()) as $key => $row) {
                                            $totalca_travelagency = $row['totalca_travelagency'];
                                            echo '<h4 class="mb-0">' . $totalca_travelagency . '</h4>';
                                        }
                                    } else {
                                        echo '<h4 class="mb-0">0</h4>';
                                    }
                                ?>
                            </div>

                            <div class="flex-shrink-0">
                                <div class="mini-stat-icon avatar-sm rounded-circle bg-primary">
                                    <span class="avatar-title">
                                        <i class="fas fa-user-alt font-size-24"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- customer -->
            <div class="col-md-4 col-sm-6 col-12">
                <div class="card card-equal mini-stats-wid rounded-4">
                    <div class="card-body">
                        <div class="d-flex">
                            <div class="flex-grow-1">
                                <p class="text-muted fw-medium">Customers</p>
                                <?php
                                    $stmt = $conn->prepare("SELECT count(ca_customer_id) as totalca_customer FROM ca_customer where user_type='10' and status='1' ");
                                    $stmt->execute();
                                    $stmt->setFetchMode(PDO::FETCH_ASSOC);
                                    if ($stmt->rowCount() > 0) {
                                        foreach (($stmt->fetchAll()) as $key => $row) {
                                            $totalca_customer = $row['totalca_customer'];
                                            echo '<h4 class="mb-0">' . $totalca_customer . '</h4>';
                                        }
                                    } else {
                                        echo '<h4 class="mb-0">0</h4>';
                                    }
                                ?>
                            </div>

                            <div class="flex-shrink-0">
                                <div class="mini-stat-icon avatar-sm rounded-circle bg-primary">
                                    <span class="avatar-title">
                                        <i class="fas fa-user-alt font-size-24"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- MF -->
            <div class="col-md-4 col-sm-6 col-12">
                <div class="card card-equal mini-stats-wid rounded-4">
                    <div class="card-body">
                        <div class="d-flex">
                            <div class="flex-grow-1">
                                <p class="text-muted fw-medium">Master Franchise</p>
                                <?php
                                    $stmt = $conn->prepare("SELECT count(master_franchisee_id) as totalmaster_franchisee FROM master_franchisee where user_type='28' and status='1' ");
                                    $stmt->execute();
                                    $stmt->setFetchMode(PDO::FETCH_ASSOC);
                                    if ($stmt->rowCount() > 0) {
                                        foreach (($stmt->fetchAll()) as $key => $row) {
                                            $totalmaster_franchisee = $row['totalmaster_franchisee'];
                                            echo '<h4 class="mb-0">' . $totalmaster_franchisee . '</h4>';
                                        }
                                    } else {
                                        echo '<h4 class="mb-0">0</h4>';
                                    }
                                ?>
                            </div>

                            <div class="flex-shrink-0">
                                <div class="mini-stat-icon avatar-sm rounded-circle bg-primary">
                                    <span class="avatar-title">
                                        <i class="fas fa-user-alt font-size-24"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- SF -->
            <div class="col-md-4 col-sm-6 col-12">
                <div class="card card-equal mini-stats-wid rounded-4">
                    <div class="card-body">
                        <div class="d-flex">
                            <div class="flex-grow-1">
                                <p class="text-muted fw-medium">Sponsor Franchise</p>
                                <?php
                                    $stmt = $conn->prepare("SELECT count(sponsor_franchisee_id) as totalsponsor_franchisee FROM sponsor_franchisee where user_type='30' and status='1' ");
                                    $stmt->execute();
                                    $stmt->setFetchMode(PDO::FETCH_ASSOC);
                                    if ($stmt->rowCount() > 0) {
                                        foreach (($stmt->fetchAll()) as $key => $row) {
                                            $totalsponsor_franchisee = $row['totalsponsor_franchisee'];
                                            echo '<h4 class="mb-0">' . $totalsponsor_franchisee . '</h4>';
                                        }
                                    } else {
                                        echo '<h4 class="mb-0">0</h4>';
                                    }
                                ?>
                            </div>

                            <div class="flex-shrink-0">
                                <div class="mini-stat-icon avatar-sm rounded-circle bg-primary">
                                    <span class="avatar-title">
                                        <i class="fas fa-user-alt font-size-24"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Franchisee -->
            <div class="col-md-4 col-sm-6 col-12">
                <div class="card card-equal mini-stats-wid rounded-4">
                    <div class="card-body">
                        <div class="d-flex">
                            <div class="flex-grow-1">
                                <p class="text-muted fw-medium">Franchise</p>
                                <?php
                                    $stmt = $conn->prepare("SELECT count(sub_franchisee_id) as totalsub_franchisee FROM sub_franchisee where user_type='29' and status='1' ");
                                    $stmt->execute();
                                    $stmt->setFetchMode(PDO::FETCH_ASSOC);
                                    if ($stmt->rowCount() > 0) {
                                        foreach (($stmt->fetchAll()) as $key => $row) {
                                            $totalsub_franchisee = $row['totalsub_franchisee'];
                                            echo '<h4 class="mb-0">' . $totalsub_franchisee . '</h4>';
                                        }
                                    } else {
                                        echo '<h4 class="mb-0">0</h4>';
                                    }
                                ?>
                            </div>

                            <div class="flex-shrink-0">
                                <div class="mini-stat-icon avatar-sm rounded-circle bg-primary">
                                    <span class="avatar-title">
                                        <i class="fas fa-user-alt font-size-24"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>