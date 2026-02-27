<div class="row">
    <!-- Employee -->
    <div class="col-xl-6 col-md-6 col-sm-12 p-3">
        <div class="card rounded-4">
            <div class="card-body">
                <div class="card-title pb-2 d-flex justify-content-between ps-3 pe-3">
                    <div class="heading">
                        <h4>Employees</h4>
                    </div>
                    <div class="dropdown">
                        <a class="" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false"><i class="mdi mdi-dots-vertical-circle-outline mdi-24px" style="color: grey;"></i></a>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <a class="dropdown-item" href="../employee/employee.php">View</a>
                            <a class="dropdown-item" href="../employee/addEmployee.php">Add New</a>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="col-12 table-responsive text-center">
                    <table class="table mb-0">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $sql1 = "SELECT * FROM employees where (status='1' or status='0' or status='3') and employee_id != '' order by employee_id desc limit 6";
                            $stmt1 = $conn->prepare($sql1);
                            $stmt1->execute();
                            $stmt1->setFetchMode(PDO::FETCH_ASSOC);
                            if ($stmt1->rowCount() > 0) {
                                foreach (($stmt1->fetchAll()) as $key => $row) {
                                    echo '<tr>
                                                <td>' . $row['employee_id'] . '</td>
                                                <td>' . $row['name'] . '</td>';
                                    if ($row['status'] == '1') {
                                        echo '<td><span class="badge badge-pill badge-soft-success font-size-12">Active</span></td>';
                                    } else {
                                        echo '<td><span class="badge badge-pill badge-soft-danger font-size-12">Removed</span></td>';
                                    }
                                    echo '</tr>';
                                }
                            }
                            ?>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
    <!-- BM -->
    <div class="col-xl-6 col-md-6 col-sm-12 p-3">
        <div class="card rounded-4">
            <div class="card-body">
                <div class="card-title pb-2 d-flex justify-content-between ps-3 pe-3">
                    <div class="heading">
                        <h4>Business Mentor</h4>
                    </div>
                    <div class="dropdown">
                        <a class="" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false"><i class="mdi mdi-dots-vertical-circle-outline mdi-24px" style="color: grey;"></i></a>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <a class="dropdown-item" href="../businessMentor/businessMentor.php">View</a>
                            <a class="dropdown-item" href="../businessMentor/addBusinessMentor.php">Add New</a>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="col-12 table-responsive text-center">
                    <table class="table mb-0">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            
                                $sql1 = "SELECT business_mentor_id as id, firstname, lastname, status FROM business_mentor 
                                                WHERE (status='1' or status='0' or status='3') and id != '' order by id desc limit 6";
                                $stmt1 = $conn->prepare($sql1);
                                $stmt1->execute();
                                $stmt1->setFetchMode(PDO::FETCH_ASSOC);
                                if ($stmt1->rowCount() > 0) {
                                    foreach (($stmt1->fetchAll()) as $key => $row) {
                                        echo '<tr>
                                                    <td>' . $row['id'] . '</td>
                                                    <td>' . $row['firstname'] . ' ' . $row['lastname'] . '</td>';
                                        if ($row['status'] == '1') {
                                            echo '<td><span class="badge badge-pill badge-soft-success font-size-12">Active</span></td>';
                                        } else {
                                            echo '<td><span class="badge badge-pill badge-soft-danger font-size-12">Removed</span></td>';
                                        }
                                        echo '</tr>';
                                    }
                                }
                            ?>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
    <!-- MF -->
    <div class="col-xl-6 col-md-6 col-sm-12 p-3">
        <div class="card rounded-4">
            <div class="card-body">
                <div class="card-title pb-2 d-flex justify-content-between ps-3 pe-3">
                    <div class="heading">
                        <h4>Master Franchisee</h4>
                    </div>
                    <div class="dropdown">
                        <a class="" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false"><i class="mdi mdi-dots-vertical-circle-outline mdi-24px" style="color: grey;"></i></a>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <a class="dropdown-item" href="../businessMentor/businessMentor.php">View</a>
                            <a class="dropdown-item" href="../businessMentor/addBusinessMentor.php">Add New</a>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="col-12 table-responsive text-center">
                    <table class="table mb-0">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            
                                $sql1 = "SELECT master_franchisee_id as id, firstname, lastname, status FROM master_franchisee 
                                                WHERE (status='1' or status='0' or status='3') and id != '' order by id desc limit 6";
                                $stmt1 = $conn->prepare($sql1);
                                $stmt1->execute();
                                $stmt1->setFetchMode(PDO::FETCH_ASSOC);
                                if ($stmt1->rowCount() > 0) {
                                    foreach (($stmt1->fetchAll()) as $key => $row) {
                                        echo '<tr>
                                                    <td>' . $row['id'] . '</td>
                                                    <td>' . $row['firstname'] . ' ' . $row['lastname'] . '</td>';
                                        if ($row['status'] == '1') {
                                            echo '<td><span class="badge badge-pill badge-soft-success font-size-12">Active</span></td>';
                                        } else {
                                            echo '<td><span class="badge badge-pill badge-soft-danger font-size-12">Removed</span></td>';
                                        }
                                        echo '</tr>';
                                    }
                                }
                            ?>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
    <!-- SF -->
    <div class="col-xl-6 col-md-6 col-sm-12 p-3">
        <div class="card rounded-4">
            <div class="card-body">
                <div class="card-title pb-2 d-flex justify-content-between ps-3 pe-3">
                    <div class="heading">
                        <h4>Sponsor Franchisee</h4>
                    </div>
                    <div class="dropdown">
                        <a class="" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false"><i class="mdi mdi-dots-vertical-circle-outline mdi-24px" style="color: grey;"></i></a>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <a class="dropdown-item" href="../businessMentor/businessMentor.php">View</a>
                            <a class="dropdown-item" href="../businessMentor/addBusinessMentor.php">Add New</a>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="col-12 table-responsive text-center">
                    <table class="table mb-0">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            
                                $sql1 = "SELECT sponsor_franchisee_id as id, firstname, lastname, status FROM sponsor_franchisee 
                                                WHERE (status='1' or status='0' or status='3') and id != '' order by id desc limit 6";
                                $stmt1 = $conn->prepare($sql1);
                                $stmt1->execute();
                                $stmt1->setFetchMode(PDO::FETCH_ASSOC);
                                if ($stmt1->rowCount() > 0) {
                                    foreach (($stmt1->fetchAll()) as $key => $row) {
                                        echo '<tr>
                                                    <td>' . $row['id'] . '</td>
                                                    <td>' . $row['firstname'] . ' ' . $row['lastname'] . '</td>';
                                        if ($row['status'] == '1') {
                                            echo '<td><span class="badge badge-pill badge-soft-success font-size-12">Active</span></td>';
                                        } else {
                                            echo '<td><span class="badge badge-pill badge-soft-danger font-size-12">Removed</span></td>';
                                        }
                                        echo '</tr>';
                                    }
                                }
                            ?>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
    <!-- TE -->
    <div class="col-xl-6 col-md-6 col-sm-12 p-3">
        <div class="card rounded-4">
            <div class="card-body">
                <div class="card-title pb-2 d-flex justify-content-between ps-3 pe-3">
                    <div class="heading">
                        <h4>Techno Enterprise</h4>
                    </div>
                    <div class="dropdown">
                        <a class="" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false"><i class="mdi mdi-dots-vertical-circle-outline mdi-24px" style="color: grey;"></i></a>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <a class="dropdown-item" href="../corporate_agency/view_corporate_agency.php">View</a>
                            <a class="dropdown-item" href="../corporate_agency/add_corporate_agency.php">Add New</a>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="col-12 table-responsive text-center">
                    <table class="table mb-0">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $sql1 = "SELECT * FROM corporate_agency where user_type='16' and (status='1' or status='0' or status='3') and corporate_agency_id != '' order by corporate_agency_id desc limit 6";
                            $stmt1 = $conn->prepare($sql1);
                            $stmt1->execute();
                            $stmt1->setFetchMode(PDO::FETCH_ASSOC);
                            if ($stmt1->rowCount() > 0) {
                                foreach (($stmt1->fetchAll()) as $key => $row) {
                                    echo '<tr>
                                                <td>' . $row['corporate_agency_id'] . '</td>
                                                <td>' . $row['firstname'] . ' ' . $row['lastname'] . '</td>';
                                    if ($row['status'] == '1') {
                                        echo '<td><span class="badge badge-pill badge-soft-success font-size-12">Active</span></td>';
                                    } else {
                                        echo '<td><span class="badge badge-pill badge-soft-danger font-size-12">Removed</span></td>';
                                    }
                                    echo '</tr>';
                                }
                            }
                            ?>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
    <!-- Franchisee -->
    <div class="col-xl-6 col-md-6 col-sm-12 p-3">
        <div class="card rounded-4">
            <div class="card-body">
                <div class="card-title pb-2 d-flex justify-content-between ps-3 pe-3">
                    <div class="heading">
                        <h4>Franchisee</h4>
                    </div>
                    <div class="dropdown">
                        <a class="" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false"><i class="mdi mdi-dots-vertical-circle-outline mdi-24px" style="color: grey;"></i></a>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <a class="dropdown-item" href="../corporate_agency/view_corporate_agency.php">View</a>
                            <a class="dropdown-item" href="../corporate_agency/add_corporate_agency.php">Add New</a>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="col-12 table-responsive text-center">
                    <table class="table mb-0">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $sql1 = "SELECT * FROM sub_franchisee where user_type='29' and (status='1' or status='0' or status='3') and sub_franchisee_id != '' order by sub_franchisee_id desc limit 6";
                            $stmt1 = $conn->prepare($sql1);
                            $stmt1->execute();
                            $stmt1->setFetchMode(PDO::FETCH_ASSOC);
                            if ($stmt1->rowCount() > 0) {
                                foreach (($stmt1->fetchAll()) as $key => $row) {
                                    echo '<tr>
                                                <td>' . $row['sub_franchisee_id'] . '</td>
                                                <td>' . $row['firstname'] . ' ' . $row['lastname'] . '</td>';
                                    if ($row['status'] == '1') {
                                        echo '<td><span class="badge badge-pill badge-soft-success font-size-12">Active</span></td>';
                                    } else {
                                        echo '<td><span class="badge badge-pill badge-soft-danger font-size-12">Removed</span></td>';
                                    }
                                    echo '</tr>';
                                }
                            }
                            ?>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
    <!-- TC -->
    <div class="col-xl-6 col-md-6 col-sm-12 p-3">
        <div class="card rounded-4">
            <div class="card-body">
                <div class="card-title pb-2 d-flex justify-content-between ps-3 pe-3">
                    <div class="heading">
                        <h4>Travel Consultant</h4>
                    </div>
                    <div class="dropdown">
                        <a class="" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false"><i class="mdi mdi-dots-vertical-circle-outline mdi-24px" style="color: grey;"></i></a>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <a class="dropdown-item" href="../ca_travel_agency/view_ca_travelAgency.php">View</a>
                            <a class="dropdown-item" href="../ca_travel_agency/add_ca_travelAgency.php">Add New</a>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="col-12 table-responsive text-center">
                    <table class="table mb-0">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $sql1 = "SELECT * FROM ca_travelagency where user_type='11' and (status='1' or status='0' or status='3') and ca_travelagency_id != '' order by ca_travelagency_id desc limit 6";
                            $stmt1 = $conn->prepare($sql1);
                            $stmt1->execute();
                            $stmt1->setFetchMode(PDO::FETCH_ASSOC);
                            if ($stmt1->rowCount() > 0) {
                                foreach (($stmt1->fetchAll()) as $key => $row) {
                                    echo '<tr>
                                                <td>' . $row['ca_travelagency_id'] . '</td>
                                                <td>' . $row['firstname'] . ' ' . $row['lastname'] . '</td>';
                                    if ($row['status'] == '1') {
                                        echo '<td><span class="badge badge-pill badge-soft-success font-size-12">Active</span></td>';
                                    } else {
                                        echo '<td><span class="badge badge-pill badge-soft-danger font-size-12">Removed</span></td>';
                                    }
                                    echo '</tr>';
                                }
                            }
                            ?>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
    <!-- customer -->
    <div class="col-xl-6 col-md-6 col-sm-12 p-3">
        <div class="card rounded-4">
            <div class="card-body">
                <div class="card-title pb-2 d-flex justify-content-between ps-3 pe-3">
                    <div class="heading">
                        <h4>Customer</h4>
                    </div>
                    <div class="dropdown">
                        <a class="" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false"><i class="mdi mdi-dots-vertical-circle-outline mdi-24px" style="color: grey;"></i></a>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <a class="dropdown-item" href="../ca_customer/view_customers.php">View</a>
                            <a class="dropdown-item" href="../ca_customer/add_customers.php">Add New</a>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="col-12 table-responsive text-center">
                    <table class="table mb-0">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $sql1 = "SELECT * FROM ca_customer where user_type='10' and (status='1' or status='0') and ca_customer_id != '' order by ca_customer_id desc limit 6";
                            $stmt1 = $conn->prepare($sql1);
                            $stmt1->execute();
                            $stmt1->setFetchMode(PDO::FETCH_ASSOC);
                            if ($stmt1->rowCount() > 0) {
                                foreach (($stmt1->fetchAll()) as $key => $row) {
                                    echo '<tr>
                                                <td>' . $row['ca_customer_id'] . '</td>
                                                <td>' . $row['firstname'] . ' ' . $row['lastname'] . '</td>';
                                    if ($row['status'] == '1') {
                                        echo '<td><span class="badge badge-pill badge-soft-success font-size-12">Active</span></td>';
                                    } else {
                                        echo '<td><span class="badge badge-pill badge-soft-danger font-size-12">Removed</span></td>';
                                    }
                                    echo '</tr>';
                                }
                            }
                            ?>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>

</div>