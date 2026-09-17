<?php
    session_start();

    if(!isset($_SESSION['username'])){
        echo '<script>location.href = "../login.php";</script>';
    }

    require '../connect.php';
    $date = date('Y'); 
?>
<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>Category | Admin</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!-- App favicon -->
        <link rel="shortcut icon" href="../assets/images/fav.png">

        <!-- bootstrap-datepicker css -->
        <link href="../assets/libs/bootstrap-datepicker/css/bootstrap-datepicker.min.css" rel="stylesheet" type="text/css">

        <!-- DataTables -->
        <link href="../assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />

        <!-- Responsive datatable examples -->
        <link href="../assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css" />  

        <!-- Bootstrap Css -->
        <link href="../assets/css/bootstrap.min.css" id="bootstrap-style" rel="stylesheet" type="text/css" />
        <!-- Icons Css -->
        <link href="../assets/css/icons.min.css" rel="stylesheet" type="text/css" />
        <!-- App Css-->
        <link href="../assets/css/app.min.css" id="app-style" rel="stylesheet" type="text/css" />
        <!-- App js -->
        <!-- <script src="../assets/js/plugin.js"></script> -->
    </head>
    <body data-sidebar="dark">
    <!-- <body data-layout="horizontal" data-topbar="dark"> -->

        <!-- Begin page -->
        <div id="layout-wrapper">
            <?php 
                // top header logo, hamberger menu, fullscreen icon, profile
                include_once '../header.php';

                // sidebar navigation menu 
                include_once '../sidebar.php';
            ?>
            <!-- ============================================================== -->
            <!-- Start right Content here -->
            <!-- ============================================================== -->
            <div class="main-content">
                <div class="page-content">
                    <div class="row d-flex justify-content-center align-items-center mt-5 d-none">
                        <div class="col-md-6">
                            <div class="card p-4">
                                <h4 class="pb-2">User Credentials</h4>
                                <div class="mb-3">
                                    <label for="username" class="form-label fs-5">Name:</label>
                                    <input type="text" class="form-control" id="username">
                                </div>
                                <div class="mb-3">
                                    <label for="inputPassword5" class="form-label fs-5">Password:</label>
                                    <input type="password" id="inputPassword5" class="form-control" aria-describedby="passwordHelpBlock">
                                </div>
                                <div class="">
                                    <button class="btn btn-primary text-black py-2 px-4 fs-5"  id="login" type="submit">Login</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="container-fluid">
                        <div id="user_cred">
                            <div class="row">
                                <div class="col-12">
                                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                        <h4 class="mb-sm-0 font-size-18">User Credentials</h4>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="card">
                                        <!-- login details table -->
                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <table class="table table-hover" id="tablePegination">
                                                    <thead>
                                                        <tr>
                                                            <th>Sr No</th>
                                                            <th>User Type</th>
                                                            <th>Name</th>
                                                            <th>Email</th>
                                                            <th>Password</th>
                                                            <th>Status</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                            require '../connect.php';
                                                            /*
                                                            |--------------------------------------------------------------------------
                                                            | GET LOGIN USERS
                                                            |--------------------------------------------------------------------------
                                                            */
                                                            $stmt = $conn->prepare("
                                                                SELECT *
                                                                FROM login
                                                                WHERE user_type_id IN (
                                                                    10, 11, 16, 24, 25, 26, 27, 28,
                                                                    29, 30, 31, 32, 33, 34, 35, 36
                                                                )
                                                                AND status = '1'
                                                            ");

                                                            $stmt->execute();
                                                            $allUsers = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                                            /*
                                                            |--------------------------------------------------------------------------
                                                            | CHECK IF LOGIN USERS EXIST
                                                            |--------------------------------------------------------------------------
                                                            */
                                                            if (count($allUsers) > 0) {
                                                                /*
                                                                |--------------------------------------------------------------------------
                                                                | DISPLAY COUNTER
                                                                |--------------------------------------------------------------------------
                                                                | Do not use $key + 1 because invalid users are skipped.
                                                                |--------------------------------------------------------------------------
                                                                */
                                                                $serialNo = 1;
                                                                foreach ($allUsers as $row) {
                                                                    /*
                                                                    |--------------------------------------------------------------------------
                                                                    | RESET VARIABLES FOR EVERY LOOP
                                                                    |--------------------------------------------------------------------------
                                                                    */
                                                                    $firstname  = '';
                                                                    $lastname   = '';
                                                                    $name       = 'Unknown';
                                                                    $userExists = false;
                                                                    $users      = null;
                                                                    /*
                                                                    |--------------------------------------------------------------------------
                                                                    | LOGIN DETAILS
                                                                    |--------------------------------------------------------------------------
                                                                    */
                                                                    $username = $row['username'];
                                                                    $password = $row['password'];
                                                                    $userId   = $row['user_id'];
                                                                    $userType = $row['user_type_id'];
                                                                    /*
                                                                    |--------------------------------------------------------------------------
                                                                    | GET USER FROM RESPECTIVE TABLE
                                                                    |--------------------------------------------------------------------------
                                                                    */
                                                                    // CUSTOMER
                                                                    if ($userType == 10) {
                                                                        $users = $conn->prepare("
                                                                            SELECT firstname, lastname
                                                                            FROM ca_customer
                                                                            WHERE ca_customer_id = ?
                                                                            AND status = '1'
                                                                        ");
                                                                        $users->execute([$userId]);
                                                                    }
                                                                    // TRAVEL CONSULTANT
                                                                    else if ($userType == 11) {
                                                                        $users = $conn->prepare("
                                                                            SELECT firstname, lastname
                                                                            FROM ca_travelagency
                                                                            WHERE ca_travelagency_id = ?
                                                                            AND status = '1'
                                                                        ");
                                                                        $users->execute([$userId]);
                                                                    }
                                                                    // TECHNO ENTERPRISE
                                                                    else if ($userType == 16) {
                                                                        $users = $conn->prepare("
                                                                            SELECT firstname, lastname
                                                                            FROM corporate_agency
                                                                            WHERE corporate_agency_id = ?
                                                                            AND status = '1'
                                                                        ");
                                                                        $users->execute([$userId]);
                                                                    }
                                                                    // BCM / BCH
                                                                    else if ($userType == 24) {
                                                                        $users = $conn->prepare("
                                                                            SELECT name
                                                                            FROM employees
                                                                            WHERE employee_id = ?
                                                                            AND user_type = '24'
                                                                            AND status = '1'
                                                                        ");
                                                                        $users->execute([$userId]);
                                                                    }
                                                                    // BDM
                                                                    else if ($userType == 25) {
                                                                        $users = $conn->prepare("
                                                                            SELECT name
                                                                            FROM employees
                                                                            WHERE employee_id = ?
                                                                            AND user_type = '25'
                                                                            AND status = '1'
                                                                        ");
                                                                        $users->execute([$userId]);
                                                                    }
                                                                    // BUSINESS MENTOR
                                                                    else if ($userType == 26) {
                                                                        $users = $conn->prepare("
                                                                            SELECT firstname, lastname
                                                                            FROM business_mentor
                                                                            WHERE business_mentor_id = ?
                                                                            AND status = '1'
                                                                        ");
                                                                        $users->execute([$userId]);
                                                                    }
                                                                    // ZONAL MANAGER
                                                                    else if ($userType == 27) {
                                                                        $users = $conn->prepare("
                                                                            SELECT name
                                                                            FROM zonal_manager
                                                                            WHERE zonal_manager_id = ?
                                                                            AND status = '1'
                                                                        ");
                                                                        $users->execute([$userId]);
                                                                    }
                                                                    // MASTER FRANCHISEE
                                                                    else if ($userType == 28) {
                                                                        $users = $conn->prepare("
                                                                            SELECT firstname, lastname
                                                                            FROM master_franchisee
                                                                            WHERE master_franchisee_id = ?
                                                                            AND status = '1'
                                                                        ");
                                                                        $users->execute([$userId]);
                                                                    }
                                                                    // FRANCHISEE
                                                                    else if ($userType == 29) {
                                                                        $users = $conn->prepare("
                                                                            SELECT firstname, lastname
                                                                            FROM sub_franchisee
                                                                            WHERE sub_franchisee_id = ?
                                                                            AND status = '1'
                                                                        ");
                                                                        $users->execute([$userId]);
                                                                    }
                                                                    // SPONSOR FRANCHISEE
                                                                    else if ($userType == 30) {
                                                                        $users = $conn->prepare("
                                                                            SELECT firstname, lastname
                                                                            FROM sponsor_franchisee
                                                                            WHERE sponsor_franchisee_id = ?
                                                                            AND status = '1'
                                                                        ");
                                                                        $users->execute([$userId]);
                                                                    }
                                                                    // REGIONAL MANAGER
                                                                    else if ($userType == 31) {
                                                                        $users = $conn->prepare("
                                                                            SELECT name
                                                                            FROM employees
                                                                            WHERE employee_id = ?
                                                                            AND user_type = '31'
                                                                            AND status = '1'
                                                                        ");
                                                                        $users->execute([$userId]);
                                                                    }
                                                                    // INSTITUTION
                                                                    else if ($userType == 32) {
                                                                        $users = $conn->prepare("
                                                                            SELECT name
                                                                            FROM institution
                                                                            WHERE institution_id = ?
                                                                            AND status = '1'
                                                                        ");
                                                                        $users->execute([$userId]);
                                                                    }
                                                                    // INSTITUTION BRANCH MANAGER
                                                                    else if ($userType == 33) {
                                                                        $users = $conn->prepare("
                                                                            SELECT firstname, lastname
                                                                            FROM institution_branch_manager
                                                                            WHERE institution_branch_manager_id = ?
                                                                            AND status = '1'
                                                                        ");
                                                                        $users->execute([$userId]);
                                                                    }
                                                                    // EXECUTIVE TECHNO ENTERPRISE
                                                                    else if ($userType == 34) {
                                                                        $users = $conn->prepare("
                                                                            SELECT firstname, lastname
                                                                            FROM executive_techno_enterprise
                                                                            WHERE executive_techno_enterprise_id = ?
                                                                            AND user_type = '34'
                                                                            AND status = '1'
                                                                        ");
                                                                        $users->execute([$userId]);
                                                                    }
                                                                    // SUPER TECHNO ENTERPRISE
                                                                    else if ($userType == 35) {

                                                                        $users = $conn->prepare("
                                                                            SELECT firstname, lastname
                                                                            FROM super_techno_enterprise
                                                                            WHERE super_techno_enterprise_id = ?
                                                                            AND user_type = '35'
                                                                            AND status = '1'
                                                                        ");

                                                                        $users->execute([$userId]);
                                                                    }
                                                                    // CHIEF TECHNO ENTERPRISE
                                                                    else if ($userType == 36) {
                                                                        $users = $conn->prepare("
                                                                            SELECT firstname, lastname
                                                                            FROM chief_techno_enterprise
                                                                            WHERE chief_techno_enterprise_id = ?
                                                                            AND user_type = '36'
                                                                            AND status = '1'
                                                                        ");

                                                                        $users->execute([$userId]);
                                                                    }
                                                                    /*
                                                                    |--------------------------------------------------------------------------
                                                                    | CHECK USER EXISTS
                                                                    |--------------------------------------------------------------------------
                                                                    |
                                                                    | IMPORTANT:
                                                                    | If login.user_id does not exist in the respective table,
                                                                    | skip this login record completely.
                                                                    |--------------------------------------------------------------------------
                                                                    */
                                                                    if ($users === null) {
                                                                        continue;
                                                                    }

                                                                    $user = $users->fetch(PDO::FETCH_ASSOC);
                                                                    /*
                                                                    |--------------------------------------------------------------------------
                                                                    | USER NOT FOUND
                                                                    |--------------------------------------------------------------------------
                                                                    |
                                                                    | Do not display the login record.
                                                                    |--------------------------------------------------------------------------
                                                                    */
                                                                    if (!$user) {
                                                                        continue;
                                                                    }
                                                                    /*
                                                                    |--------------------------------------------------------------------------
                                                                    | USER EXISTS
                                                                    |--------------------------------------------------------------------------
                                                                    */
                                                                    $userExists = true;
                                                                    /*
                                                                    |--------------------------------------------------------------------------
                                                                    | GET USER NAME
                                                                    |--------------------------------------------------------------------------
                                                                    */
                                                                    // Tables having only "name"
                                                                    if (
                                                                        $userType == 24 ||
                                                                        $userType == 25 ||
                                                                        $userType == 27 ||
                                                                        $userType == 31 ||
                                                                        $userType == 32
                                                                    ) {
                                                                        $firstname = $user['name'] ?? '';
                                                                        $lastname  = '';
                                                                    } else {

                                                                        $firstname = $user['firstname'] ?? '';
                                                                        $lastname  = $user['lastname'] ?? '';
                                                                    }
                                                                    /*
                                                                    |--------------------------------------------------------------------------
                                                                    | GET USER TYPE NAME
                                                                    |--------------------------------------------------------------------------
                                                                    */
                                                                    $users_types = $conn->prepare("
                                                                        SELECT name
                                                                        FROM user_type
                                                                        WHERE id = ?
                                                                        AND status = '1'
                                                                    ");
                                                                    $users_types->execute([$userType]);
                                                                    $users_type = $users_types->fetch(PDO::FETCH_ASSOC);
                                                                    if ($users_type) {
                                                                        $name = $users_type['name'];
                                                                    }
                                                                    /*
                                                                    |--------------------------------------------------------------------------
                                                                    | DISPLAY USER
                                                                    |--------------------------------------------------------------------------
                                                                    |
                                                                    | Since invalid users were already skipped above,
                                                                    | every row displayed here is a valid user.
                                                                    |--------------------------------------------------------------------------
                                                                    */
                                                                    echo '<tr>';
                                                                    /*
                                                                    |--------------------------------------------------------------------------
                                                                    | SERIAL NUMBER
                                                                    |--------------------------------------------------------------------------
                                                                    */
                                                                    echo '
                                                                        <td style="text-align:center;">
                                                                            ' . $serialNo . '
                                                                        </td>
                                                                    ';
                                                                    /*
                                                                    |--------------------------------------------------------------------------
                                                                    | USER TYPE
                                                                    |--------------------------------------------------------------------------
                                                                    */
                                                                    echo '
                                                                        <td>
                                                                            ' . htmlspecialchars($name) . '
                                                                        </td>
                                                                    ';
                                                                    /*
                                                                    |--------------------------------------------------------------------------
                                                                    | USER NAME
                                                                    |--------------------------------------------------------------------------
                                                                    */
                                                                    echo '
                                                                        <td>
                                                                            ' . htmlspecialchars(
                                                                                trim($firstname . ' ' . $lastname)
                                                                            ) . '
                                                                        </td>
                                                                    ';
                                                                    /*
                                                                    |--------------------------------------------------------------------------
                                                                    | USERNAME
                                                                    |--------------------------------------------------------------------------
                                                                    */
                                                                    echo '
                                                                        <td>
                                                                            ' . htmlspecialchars($username) . '
                                                                        </td>
                                                                    ';
                                                                    /*
                                                                    |--------------------------------------------------------------------------
                                                                    | PASSWORD
                                                                    |--------------------------------------------------------------------------
                                                                    */
                                                                    echo '
                                                                        <td>
                                                                            ' . htmlspecialchars($password) . '
                                                                        </td>
                                                                    ';
                                                                    /*
                                                                    |--------------------------------------------------------------------------
                                                                    | LOGIN STATUS
                                                                    |--------------------------------------------------------------------------
                                                                    */
                                                                    echo '<td style="text-align:center;">';
                                                                    if ($row['status'] == 1) {
                                                                        echo '
                                                                            <span class="badge text-bg-success">
                                                                                Active
                                                                            </span>
                                                                        ';
                                                                    } else if ($row['status'] == 3) {
                                                                        echo '
                                                                            <span class="badge text-bg-warning">
                                                                                Inactive
                                                                            </span>
                                                                        ';
                                                                    } else {
                                                                        echo '
                                                                            <span class="badge text-bg-danger">
                                                                                Delete
                                                                            </span>
                                                                        ';
                                                                    }
                                                                    echo '</td>';
                                                                    echo '</tr>';
                                                                    /*
                                                                    |--------------------------------------------------------------------------
                                                                    | INCREMENT SERIAL NUMBER
                                                                    |--------------------------------------------------------------------------
                                                                    */
                                                                    $serialNo++;
                                                                }
                                                            } else {
                                                                /*
                                                                |--------------------------------------------------------------------------
                                                                | NO LOGIN USERS
                                                                |--------------------------------------------------------------------------
                                                                */
                                                                echo '
                                                                    <tr>
                                                                        <td style="text-align:center;" colspan="6">
                                                                            No Users Found
                                                                        </td>
                                                                    </tr>
                                                                ';
                                                            }
                                                        ?>

                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> <!-- container-fluid -->
                </div> <!-- End Page-content -->

                
                <?php include_once "../footer.php" ?>
            </div>
            <!-- end main content-->

        </div>
        <!-- END layout-wrapper -->

        <!-- JAVASCRIPT -->
        <script src="../assets/libs/jquery/jquery.min.js"></script>
        <script src="../assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
        <script src="../assets/libs/metismenu/metisMenu.min.js"></script>
        <script src="../assets/libs/simplebar/simplebar.min.js"></script>
        <script src="../assets/libs/node-waves/waves.min.js"></script>
        <!-- bootstrap-datepicker js -->
        <script src="../assets/libs/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>

        <!-- Required datatable js -->
        <script src="../assets/libs/datatables.net/js/jquery.dataTables.min.js"></script>
        <script src="../assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>
        
        <!-- Responsive examples -->
        <script src="../assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
        <script src="../assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js"></script>
        <!-- App js -->
        <script src="../assets/js/app.js"></script>
        
        <script type="text/javascript">
         $(document).ready(function(){
                $("#tablePegination").DataTable();
            });
        </script>
    </body>
</html>