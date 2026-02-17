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
                                                            
                                                            $stmt = $conn->prepare("SELECT * FROM login WHERE (user_type_id ='10' || user_type_id ='11' || user_type_id ='16' || user_type_id ='24' || user_type_id ='25' || user_type_id ='26' || user_type_id ='27' || user_type_id ='28' || user_type_id ='29' || user_type_id ='30' || user_type_id ='31')  AND status='1'");
                                                            $stmt->execute();
                                                            $stmt->setFetchMode(PDO::FETCH_ASSOC);
                                                            $firstname='';
                                                            $lastneam='';
                                                            if($stmt->rowCount()>0){
                                                                foreach (($stmt->fetchAll()) as $key => $row) {
                                                                    // $quotation_id =$row['id'];
                                                                    $username= $row['username'];
                                                                    $password= $row['password'];
                                                                    $userId= $row['user_id'];
                                                                    $userType= $row['user_type_id'];

                                                                    // //get users
                                                                    //customer
                                                                    if ( $userType == 10 ) {
                                                                        $users = $conn->prepare("SELECT firstname,lastname FROM ca_customer where ca_customer_id='".$userId."' AND status='1'  ");
                                                                    }
                                                                    //Travel consultant 
                                                                    else if ( $userType == 11 ) {
                                                                        $users = $conn->prepare("SELECT firstname,lastname FROM ca_travelagency where ca_travelagency_id='".$userId."' AND status='1'  ");
                                                                    }
                                                                    //Techno Enterprise
                                                                     else if ( $userType == 16 ) {
                                                                        $users = $conn->prepare("SELECT firstname,lastname FROM corporate_agency where corporate_agency_id='".$userId."' AND status='1' ");
                                                                    } 
                                                                    //BCM/BCH
                                                                    else if ( $userType == 24 ) {
                                                                        $users = $conn->prepare("SELECT name FROM employees where employee_id='".$userId."' AND user_type = '24' AND status='1'  ");
                                                                    } 
                                                                    //BDM
                                                                    else if ( $userType == 25 ) {
                                                                        $users = $conn->prepare("SELECT name FROM employees where employee_id='".$userId."' AND user_type = '25' AND status='1' ");
                                                                    } 
                                                                    //BM
                                                                    else if ( $userType == 26 ) {
                                                                        $users = $conn->prepare("SELECT firstname,lastname FROM business_mentor where business_mentor_id='".$userId."' AND status='1' ");
                                                                    } 
                                                                    //ZM
                                                                    else if ( $userType == 27 ) {
                                                                        $users = $conn->prepare("SELECT name FROM zonal_manager where zonal_manager_id='".$userId."' AND status='1' ");
                                                                    } 
                                                                    //MF
                                                                    else if ( $userType == 28 ) {
                                                                        $users = $conn->prepare("SELECT firstname,lastname FROM master_franchisee where master_franchisee_id='".$userId."' AND status='1' ");
                                                                    }
                                                                    //Franchisee 
                                                                    else if ( $userType == 29 ) {
                                                                        $users = $conn->prepare("SELECT firstname,lastname FROM sub_franchisee where sub_franchisee_id='".$userId."' AND status='1' ");
                                                                    }  
                                                                    //SF
                                                                    else if ( $userType == 30 ) {
                                                                        $users = $conn->prepare("SELECT firstname,lastname FROM sponsor_franchisee where sponsor_franchisee_id='".$userId."' AND status='1' ");
                                                                    }
                                                                    //RM
                                                                    else if ( $userType == 31 ) {
                                                                        $users = $conn->prepare("SELECT name FROM employees where employee_id='".$userId."' AND user_type = '31' AND status='1'");
                                                                    } 
                                                                    $users->execute();
                                                                    $users->setFetchMode(PDO::FETCH_ASSOC);
                                                                    if($users->rowCount()>0){
                                                                        $user = $users->fetch();
                                                                        if($userType == 24 || $userType == 25 || $userType == 27 || $userType == 31){
                                                                            $firstname = $user['name'] ;
                                                                            $lastneam =  '';
                                                                        } else{
                                                                            $firstname = $user['firstname'] ;
                                                                            $lastneam =  $user['lastname'];
                                                                        }
                                                                    }
                                                                    
                                                                    //get user type
                                                                    $users_types = $conn->prepare("SELECT name FROM user_type where id='".$userType."' AND status='1' ");
                                                                    $users_types->execute();
                                                                    $users_types->setFetchMode(PDO::FETCH_ASSOC);
                                                                    if($users_types->rowCount()>0){
                                                                        $users_type = $users_types->fetch();
                                                                        $name = $users_type['name'];
                                                                    }

                                                                    echo '<tr>
                                                                            <td style="text-align: center;">'.++$key.'</td>
                                                                            <td>'. $name.' </td>
                                                                            <td>'.$firstname.' '.$lastneam.' </td>
                                                                            <td>'.$username.' </td>
                                                                            <td>'.$password.' </td>';
                                                                            if($row['status']==1){
                                                                            echo '<td style="text-align: center;"><span class="badge text-bg-success">Active</span> </td>';
                                                                            }else if($row['status']==3){
                                                                                echo '<td style="text-align: center;"><span class="badge text-bg-warning">Inactive</span> </td>';
                                                                            }else{
                                                                                echo '<td style="text-align: center;"><span class="badge text-bg-danger">Delete</span> </td>';
                                                                            }
                                                                            
                                                                    echo '</tr>';

                                                                } 
                                                            }
                                                            else
                                                            {
                                                                echo '<tr>
                                                                        <td style="text-align:center;" colspan="8">No Users Found</td>
                                                                    <tr>';
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