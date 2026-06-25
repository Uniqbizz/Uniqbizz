<?php
    include (__DIR__.'/urls.php');
    include_once(__DIR__ . '/../dashboard_user_details.php');
    include (__DIR__ .'/customer_model.php');
    include (__DIR__ .'/customer_mapping.php');
?>
<!doctype html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg" data-sidebar-image="none" data-preloader="disable">
    <head>

        <meta charset="utf-8" />
        <title> Dashboard | Customer</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!-- App favicon -->
        <link rel="shortcut icon" href="../assets/images/fav.png">

        <!-- jsvectormap css -->
        <link href="../assets/libs/jsvectormap/css/jsvectormap.min.css" rel="stylesheet" type="text/css" />

        <!--Swiper slider css-->
        <link href="../assets/libs/swiper/swiper-bundle.min.css" rel="stylesheet" type="text/css" />

        <!-- DataTables -->
        <link href="../assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
        <!-- Responsive datatable examples -->
        <link href="../assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css" />  

        <!-- Layout config Js -->
        <script src="../assets/js/layout.js"></script>
        <!-- Bootstrap Css -->
        <link href="../assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <!-- Icons Css -->
        <link href="../assets/css/icons.min.css" rel="stylesheet" type="text/css" />
        <!-- App Css-->
        <link href="../assets/css/app.min.css" rel="stylesheet" type="text/css" />
        <!-- custom Css-->
        <link href="../assets/css/custom.min.css" rel="stylesheet" type="text/css" />
        <!-- custom Css developer-->
        <link rel="stylesheet" href="../assets/css/custom.css" />
        <!-- font-awesome -->
        <link rel="stylesheet" href="../assets/fontawesome/css/all.min.css" />
        <!-- Customer Dashboard CSS -->
        <link rel="stylesheet" href="../assets/css/customer_dashboard.css" />
        <!-- FontAwesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        
    </head>

    <body>
 
        <!-- Begin page -->
        <div id="layout-wrapper">

            <?php 
                include_once(__DIR__ . '/customer_header.php');
            ?>

            <!-- removeNotificationModal -->
            <div id="removeNotificationModal" class="modal fade zoomIn" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="NotificationModalbtn-close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mt-2 text-center">
                                <lord-icon src="../../../../cdn.lordicon.com/gsqxdxog.json" trigger="loop" colors="primary:#f7b84b,secondary:#f06548" style="width:100px;height:100px"></lord-icon>
                                <div class="mt-4 pt-2 fs-15 mx-4 mx-sm-5">
                                    <h4>Are you sure ?</h4>
                                    <p class="text-muted mx-4 mb-0">Are you sure you want to remove this Notification ?</p>
                                </div>
                            </div>
                            <div class="d-flex gap-2 justify-content-center mt-4 mb-2">
                                <button type="button" class="btn w-sm btn-light" data-bs-dismiss="modal">Close</button>
                                <button type="button" class="btn w-sm btn-danger" id="delete-notification">Yes, Delete It!</button>
                            </div>
                        </div>

                    </div><!-- /.modal-content -->
                </div><!-- /.modal-dialog -->
            </div><!-- /.modal -->
            <!-- ========== App Menu ========== -->
            <?php
                include_once(__DIR__ . '/customer_sidebar.php');
            ?>

            <!-- ============================================================== -->
            <!-- Start right Content here -->
            <!-- ============================================================== -->
            <div class="main-content">

                <div class="page-content">
                    <div class="container-fluid">
                        <!-- start page title -->
                        <div class="row">
                            <div class="col-12">
                                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                    <h4 class="mb-sm-0">Refer & Earn</h4>

                                    <div class="page-title-right">
                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="<?= $base_url_cust ?>customer_dashboard.php">Dashboard</a></li>
                                            <li class="breadcrumb-item active">Refer & Earn</li>
                                        </ol>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <!-- end page title -->
                        <!-- Card section 1 -->
                        <div class="row">
                            <div class="col-xl-3 col-lg-4 col-md-4 col-sm-6 col-12">
                                <div class="card rounded-4 border-1 p-3">
                                    <div class="row">
                                        <div class="col-lg-3 col-md-3 col-sm-3 col-3 align-content-center">
                                            <div class="referIcon referIcon1">
                                                <i class="fa-solid fa-user fa-xl"></i>
                                            </div>
                                        </div>
                                        <div class="col-lg-9 col-md-9 col-sm-9 col-9">
                                            <p class="mb-0 fw-bolder">Total Referrals</p>
                                            <div class="d-flex justify-content-between">
                                                <p class="mb-0 fs-5 fw-bolder">0</p>
                                                <p class="mb-0"><i class="fa-solid fa-user-group fa-lg" style="color: #35239a;"></i></p>
                                            </div>
                                            <p class="mb-0 text-muted fs-6">All time</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-lg-4 col-md-4 col-sm-6 col-12">
                                <div class="card rounded-4 border-1 p-3">
                                    <div class="row">
                                        <div class="col-lg-3 col-md-3 col-sm-3 col-3 align-content-center">
                                            <div class="referIcon referIcon2">
                                                <i class="fa-solid fa-clock fa-xl"></i>
                                            </div>
                                        </div>
                                        <div class="col-lg-9 col-md-9 col-sm-9 col-9">
                                            <p class="mb-0 fw-bolder">Pending Referrals</p>
                                            <p class="mb-0 fs-5 fw-bolder">0</p>
                                            <p class="mb-0 text-muted fs-6">Awaiting registration</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-lg-4 col-md-4 col-sm-6 col-12">
                                <div class="card rounded-4 border-1 p-3">
                                    <div class="row">
                                        <div class="col-lg-3 col-md-3 col-sm-3 col-3 align-content-center">
                                            <div class="referIcon referIcon3">
                                                <i class="fa-solid fa-user-check fa-xl"></i>
                                            </div>
                                        </div>
                                        <div class="col-lg-9 col-md-9 col-sm-9 col-9">
                                            <p class="mb-0 fw-bolder">Registered Referrals</p>
                                            <p class="mb-0 fs-5 fw-bolder">0</p>
                                            <p class="mb-0 text-muted fs-6">Successfully joined</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-lg-4 col-md-4 col-sm-6 col-12">
                                <div class="card rounded-4 border-1 p-3">
                                    <div class="row">
                                        <div class="col-lg-3 col-md-3 col-sm-3 col-3 align-content-center">
                                            <div class="referIcon referIcon4">
                                                <i class="fa-solid fa-gift fa-xl"></i>
                                            </div>
                                        </div>
                                        <div class="col-lg-9 col-md-9 col-sm-9 col-9">
                                            <p class="mb-0 fw-bolder">Rewards Earned</p>
                                            <p class="mb-0 fs-5 fw-bolder textViolet">&#8377;0</p>
                                            <p class="mb-0 text-muted fs-6">Total cashback</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col">

                                <div class="h-100">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="card">
                                                <div class="card-header border-bottom-dashed">
                                                    <div class="row g-4 align-items-center">
                                                        <div class="col-sm">
                                                            <div>
                                                                <h5 class="card-title mb-0">Pending List</h5>
                                                            </div>
                                                        </div>
                                                        
                                                    </div>   
                                                </div>    
                                                <div class="card-body">
                                                    <table id="example-dataTable" class="table table-bordered dt-responsive nowrap table-striped align-middle" style="width:100%">
                                                        <thead>
                                                            <tr>
                                                                <th data-ordering="false">SR No.</th>
                                                                <th data-ordering="false">Name</th>
                                                                <th data-ordering="false">Reference ID and Name</th>
                                                                <th data-ordering="false">Phone</th>
                                                                <th data-ordering="false">Joining Date</th>
                                                                <th data-ordering="false">Status</th>
                                                                
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php

                                                                if($userType == "24"){
                                                                    $stmt = $conn -> prepare("SELECT employee_id FROM `employees` WHERE reporting_manager = ? AND user_type = '25' ");
                                                                    $stmt -> execute([$userId]);
                                                                    $userBDMS = $stmt -> fetchAll(PDO::FETCH_ASSOC);
                                                                    
                                                                    foreach( $userBDMS as $userBDM ){
                                                                        $bdm_id = $userBDM['employee_id'];
                                                                        
                                                                        $stmt2 = $conn->prepare("SELECT business_mentor_id FROM business_mentor WHERE reference_no = ? AND user_type = '26' ");
                                                                        $stmt2->execute([$bdm_id]);
                                                                        $userBMS = $stmt2->fetchAll(PDO::FETCH_ASSOC);
                                                                        //BM->TE->TC->TC->CU
                                                                        foreach ($userBMS as $userBM) {
                                                                            $bm_id = $userBM['business_mentor_id'];

                                                                            $stmt3 = $conn->prepare("SELECT corporate_agency_id FROM `corporate_agency` WHERE reference_no = ? ");
                                                                            $stmt3->execute([$bm_id]);
                                                                            $userCAs = $stmt3->fetchAll(PDO::FETCH_ASSOC);

                                                                            foreach($userCAs as $userCA){
                                                                                $userCAID = $userCA['corporate_agency_id'];
                                                                                // echo $userCA;

                                                                                $stmt4 = $conn->prepare("SELECT ca_travelagency_id FROM ca_travelagency WHERE reference_no = ?");
                                                                                $stmt4->execute([$userCA['corporate_agency_id']]);
                                                                                $userCATAs = $stmt4->fetchAll(PDO::FETCH_ASSOC);

                                                                                foreach ($userCATAs as $userCATA) {
                                                                                    $userTA = $userCATA['ca_travelagency_id'];
                                                                                //    echo $userCA.'=>'.$userTA.'</br>';

                                                                                    $stmt5 = $conn->prepare("SELECT * FROM ca_customer WHERE ta_reference_no = ? AND (status ='2' OR status = '0') ");
                                                                                    $stmt5->execute([$userCATA['ca_travelagency_id']]);
                                                                                    $userCACUs = $stmt5->fetchAll(PDO::FETCH_ASSOC);

                                                                                    foreach ($userCACUs as $userCACU) {
                                                                                        $userCU = $userCACU['id'];
                                                                                        // echo $userId.'=>'.$userCA.'=>'.$userTA.'=>'.$userCU.'</br>';

                                                                                        $bd= new DateTime($userCACU['date_of_birth']);
                                                                                        $bdate= $bd->format('d-m-Y');
                                                                                        $dt= new DateTime($userCACU['added_on']);
                                                                                        $datev= $dt->format('d-m-Y'); 
                                                                                        echo'<tr>
                                                                                            <td>'.$userCACU['id'].'</td>
                                                                                            <td>'.$userCACU['firstname'].' '.$userCACU['lastname'].'</td>
                                                                                            <td>
                                                                                                <p>'.$userCACU['reference_no'].' '.$userCACU['registrant'].'</p>
                                                                                                <p>'.$userCACU['ta_reference_no'].' '.$userCACU['ta_reference_name'].'</p>
                                                                                            </td>
                                                                                            <td>'.$userCACU['contact_no'].'</td>
                                                                                            <td>'.$datev.'</td>';
                                                                                            if($userCACU['status'] == '2')
                                                                                                echo'<td><span class="badge bg-warning">Pending</span></td>';
                                                                                            else{
                                                                                                echo'<td><span class="badge bg-danger">Deleted</span></td>';
                                                                                            }
                                                                                        echo'</tr>';
                                                                                    }
                                                                                }   
                                                                            }
                                                                            
                                                                            //direct TC with BM Ref
                                                                            $stmt4 = $conn->prepare("SELECT ca_travelagency_id FROM ca_travelagency WHERE reference_no = ?");
                                                                            $stmt4->execute([$bm_id]);
                                                                            $userCATAs = $stmt4->fetchAll(PDO::FETCH_ASSOC);

                                                                            foreach ($userCATAs as $userCATA) {
                                                                                $userTA = $userCATA['ca_travelagency_id'];
                                                                            //    echo $userCA.'=>'.$userTA.'</br>';

                                                                                $stmt5 = $conn->prepare("SELECT * FROM ca_customer WHERE ta_reference_no = ? AND (status ='2' OR status = '0') ");
                                                                                $stmt5->execute([$userCATA['ca_travelagency_id']]);
                                                                                $userCACUs = $stmt5->fetchAll(PDO::FETCH_ASSOC);

                                                                                foreach ($userCACUs as $userCACU) {
                                                                                    $userCU = $userCACU['id'];
                                                                                    // echo $userId.'=>'.$userCA.'=>'.$userTA.'=>'.$userCU.'</br>';

                                                                                    $bd= new DateTime($userCACU['date_of_birth']);
                                                                                    $bdate= $bd->format('d-m-Y');
                                                                                    $dt= new DateTime($userCACU['added_on']);
                                                                                    $datev= $dt->format('d-m-Y'); 
                                                                                    echo'<tr>
                                                                                        <td>'.$userCACU['id'].'</td>
                                                                                        <td>'.$userCACU['firstname'].' '.$userCACU['lastname'].'</td>
                                                                                        <td>
                                                                                            <p>'.$userCACU['reference_no'].' '.$userCACU['registrant'].'</p>
                                                                                            <p>'.$userCACU['ta_reference_no'].' '.$userCACU['ta_reference_name'].'</p>
                                                                                        </td>
                                                                                        <td>'.$userCACU['contact_no'].'</td>
                                                                                        <td>'.$datev.'</td>';
                                                                                        if($userCACU['status'] == '2')
                                                                                            echo'<td><span class="badge bg-warning">Pending</span></td>';
                                                                                        else{
                                                                                            echo'<td><span class="badge bg-danger">Deleted</span></td>';
                                                                                        }
                                                                                    echo'</tr>';
                                                                                }
                                                                            }
                                                                        }
                                                                        //MF/SF->F->TC->TC->CU
                                                                        $stmt2 = $conn->prepare("SELECT master_franchisee_id AS id FROM master_franchisee WHERE reference_no = ? AND user_type = '28'
                                                                                                    UNION
                                                                                                    SELECT sponsor_franchisee_id AS id FROM sponsor_franchisee WHERE reference_no = ? AND user_type = '30' ");
                                                                        $stmt2->execute([$bdm_id,$bdm_id]);
                                                                        $userBMS = $stmt2->fetchAll(PDO::FETCH_ASSOC);
                                                                        foreach ($userBMS as $userBM) {
                                                                            $bm_id = $userBM['id'];

                                                                            $stmt3 = $conn->prepare("SELECT sub_franchisee_id AS suser_id FROM `sub_franchisee` WHERE reference_no = ?
                                                                                                    UNION ALL
                                                                                                    SELECT institution_id AS suser_id FROM institution WHERE reference_no = ?");
                                                                            $stmt3->execute([$bm_id,$bm_id]);
                                                                            $userCAs = $stmt3->fetchAll(PDO::FETCH_ASSOC);

                                                                            foreach($userCAs as $userCA){
                                                                                $userCAID = $userCA['suser_id'];
                                                                                // echo $userCA;

                                                                                $stmt4 = $conn->prepare("SELECT ca_travelagency AS user_id FROM ca_travelagency WHERE reference_no = ?
                                                                                                        UNION ALL
                                                                                                        SELECT institution_branch_manager_id AS user_id FROM institution_branch_manager WHERE reference_no = ?");
                                                                                $stmt4->execute([$userCA['suser_id'],$userCA['suser_id']]);
                                                                                $userCATAs = $stmt4->fetchAll(PDO::FETCH_ASSOC);

                                                                                foreach ($userCATAs as $userCATA) {
                                                                                    $userTA = $userCATA['user_id'];
                                                                                //    echo $userCA.'=>'.$userTA.'</br>';

                                                                                    $stmt5 = $conn->prepare("SELECT * FROM ca_customer WHERE ta_reference_no = ? AND (status ='2' OR status = '0') ");
                                                                                    $stmt5->execute([$userCATA['user_id']]);
                                                                                    $userCACUs = $stmt5->fetchAll(PDO::FETCH_ASSOC);

                                                                                    foreach ($userCACUs as $userCACU) {
                                                                                        $userCU = $userCACU['id'];
                                                                                        // echo $userId.'=>'.$userCA.'=>'.$userTA.'=>'.$userCU.'</br>';

                                                                                        $bd= new DateTime($userCACU['date_of_birth']);
                                                                                        $bdate= $bd->format('d-m-Y');
                                                                                        $dt= new DateTime($userCACU['added_on']);
                                                                                        $datev= $dt->format('d-m-Y'); 
                                                                                        echo'<tr>
                                                                                            <td>'.$userCACU['id'].'</td>
                                                                                            <td>'.$userCACU['firstname'].' '.$userCACU['lastname'].'</td>
                                                                                            <td>
                                                                                                <p>'.$userCACU['reference_no'].' '.$userCACU['registrant'].'</p>
                                                                                                <p>'.$userCACU['ta_reference_no'].' '.$userCACU['ta_reference_name'].'</p>
                                                                                            </td>
                                                                                            <td>'.$userCACU['contact_no'].'</td>
                                                                                            <td>'.$datev.'</td>';
                                                                                            if($userCACU['status'] == '2')
                                                                                                echo'<td><span class="badge bg-warning">Pending</span></td>';
                                                                                            else{
                                                                                                echo'<td><span class="badge bg-danger">Deleted</span></td>';
                                                                                            }
                                                                                        echo'</tr>';
                                                                                    }
                                                                                }   
                                                                            }
                                                                            
                                                                            //direct TC with BM Ref
                                                                            $stmt4 = $conn->prepare("SELECT ca_travelagency_id FROM ca_travelagency WHERE reference_no = ?");
                                                                            $stmt4->execute([$bm_id]);
                                                                            $userCATAs = $stmt4->fetchAll(PDO::FETCH_ASSOC);

                                                                            foreach ($userCATAs as $userCATA) {
                                                                                $userTA = $userCATA['ca_travelagency_id'];
                                                                                //    echo $userCA.'=>'.$userTA.'</br>';

                                                                                $stmt5 = $conn->prepare("SELECT * FROM ca_customer WHERE ta_reference_no = ? AND (status ='2' OR status = '0') ");
                                                                                $stmt5->execute([$userCATA['ca_travelagency_id']]);
                                                                                $userCACUs = $stmt5->fetchAll(PDO::FETCH_ASSOC);

                                                                                foreach ($userCACUs as $userCACU) {
                                                                                    $userCU = $userCACU['id'];
                                                                                    // echo $userId.'=>'.$userCA.'=>'.$userTA.'=>'.$userCU.'</br>';

                                                                                    $bd= new DateTime($userCACU['date_of_birth']);
                                                                                    $bdate= $bd->format('d-m-Y');
                                                                                    $dt= new DateTime($userCACU['added_on']);
                                                                                    $datev= $dt->format('d-m-Y'); 
                                                                                    echo'<tr>
                                                                                        <td>'.$userCACU['id'].'</td>
                                                                                        <td>'.$userCACU['firstname'].' '.$userCACU['lastname'].'</td>
                                                                                        <td>
                                                                                            <p>'.$userCACU['reference_no'].' '.$userCACU['registrant'].'</p>
                                                                                            <p>'.$userCACU['ta_reference_no'].' '.$userCACU['ta_reference_name'].'</p>
                                                                                        </td>
                                                                                        <td>'.$userCACU['contact_no'].'</td>
                                                                                        <td>'.$datev.'</td>';
                                                                                        if($userCACU['status'] == '2')
                                                                                            echo'<td><span class="badge bg-warning">Pending</span></td>';
                                                                                        else{
                                                                                            echo'<td><span class="badge bg-danger">Deleted</span></td>';
                                                                                        }
                                                                                    echo'</tr>';
                                                                                }
                                                                            }
                                                                        }
                                                                        //direct BDM->TC->CU by BDM ref
                                                                        $stmt4 = $conn->prepare("SELECT ca_travelagency_id FROM ca_travelagency WHERE reference_no = ?");
                                                                        $stmt4->execute([$bdm_id]);
                                                                        $userCATAs = $stmt4->fetchAll(PDO::FETCH_ASSOC);

                                                                        foreach ($userCATAs as $userCATA) {
                                                                            $userTA = $userCATA['ca_travelagency_id'];
                                                                        

                                                                            $stmt5 = $conn->prepare("SELECT * FROM ca_customer WHERE ta_reference_no = ? AND (status ='2' OR status = '0') ");
                                                                            $stmt5->execute([$userCATA['ca_travelagency_id']]);
                                                                            $userCACUs = $stmt5->fetchAll(PDO::FETCH_ASSOC);

                                                                            foreach ($userCACUs as $userCACU) {
                                                                                $userCU = $userCACU['id'];
                                                                                // echo $userId.'=>'.$userCA.'=>'.$userTA.'=>'.$userCU.'</br>';

                                                                                $bd= new DateTime($userCACU['date_of_birth']);
                                                                                $bdate= $bd->format('d-m-Y');
                                                                                $dt= new DateTime($userCACU['added_on']);
                                                                                $datev= $dt->format('d-m-Y'); 
                                                                                echo'<tr>
                                                                                    <td>'.$userCACU['id'].'</td>
                                                                                    <td>'.$userCACU['firstname'].' '.$userCACU['lastname'].'</td>
                                                                                    <td>
                                                                                        <p>'.$userCACU['reference_no'].' '.$userCACU['registrant'].'</p>
                                                                                        <p>'.$userCACU['ta_reference_no'].' '.$userCACU['ta_reference_name'].'</p>
                                                                                    </td>
                                                                                    <td>'.$userCACU['contact_no'].'</td>
                                                                                    <td>'.$datev.'</td>';
                                                                                    if($userCACU['status'] == '2')
                                                                                        echo'<td><span class="badge bg-warning">Pending</span></td>';
                                                                                    else{
                                                                                        echo'<td><span class="badge bg-danger">Deleted</span></td>';
                                                                                    }
                                                                                echo'</tr>';
                                                                            }
                                                                        }
                                                                        //BDM->TE->TC->CU
                                                                        $stmt3 = $conn->prepare("SELECT corporate_agency_id FROM `corporate_agency` WHERE reference_no = ? ");
                                                                        $stmt3->execute([$bdm_id]);
                                                                        $userCAs = $stmt3->fetchAll(PDO::FETCH_ASSOC);

                                                                        foreach($userCAs as $userCA){
                                                                            $userCAID = $userCA['corporate_agency_id'];
                                                                            // echo $userCA;

                                                                            $stmt4 = $conn->prepare("SELECT * FROM ca_travelagency WHERE reference_no = ?");
                                                                            $stmt4->execute([$userCA['corporate_agency_id']]);
                                                                            $userCATAs = $stmt4->fetchAll(PDO::FETCH_ASSOC);

                                                                            foreach ($userCATAs as $userCATA) {
                                                                                $userTA = $userCATA['ca_travelagency_id'];
                                                                            //    echo $userCA.'=>'.$userTA.'</br>';

                                                                                $stmt5 = $conn->prepare("SELECT * FROM ca_customer WHERE ta_reference_no = ? AND (status ='2' OR status = '0') ");
                                                                                $stmt5->execute([$userCATA['ca_travelagency_id']]);
                                                                                $userCACUs = $stmt5->fetchAll(PDO::FETCH_ASSOC);

                                                                                foreach ($userCACUs as $userCACU) {
                                                                                    $userCU = $userCACU['id'];
                                                                                    // echo $userId.'=>'.$userCA.'=>'.$userTA.'=>'.$userCU.'</br>';

                                                                                    $bd= new DateTime($userCACU['date_of_birth']);
                                                                                    $bdate= $bd->format('d-m-Y');
                                                                                    $dt= new DateTime($userCACU['added_on']);
                                                                                    $datev= $dt->format('d-m-Y'); 
                                                                                    echo'<tr>
                                                                                        <td>'.$userCACU['id'].'</td>
                                                                                        <td>'.$userCACU['firstname'].' '.$userCACU['lastname'].'</td>
                                                                                        <td>
                                                                                            <p>'.$userCACU['reference_no'].' '.$userCACU['registrant'].'</p>
                                                                                            <p>'.$userCACU['ta_reference_no'].' '.$userCACU['ta_reference_name'].'</p>
                                                                                        </td>
                                                                                        <td>'.$userCACU['contact_no'].'</td>
                                                                                        <td>'.$datev.'</td>';
                                                                                        if($userCACU['status'] == '2')
                                                                                            echo'<td><span class="badge bg-warning">Pending</span></td>';
                                                                                        else{
                                                                                            echo'<td><span class="badge bg-danger">Deleted</span></td>';
                                                                                        }
                                                                                    echo'</tr>';
                                                                                }
                                                                            }   
                                                                        }
                                                                        //BDM->F/I->TC/IBR->CU
                                                                        $stmt3 = $conn->prepare("SELECT sub_franchisee_id AS suser_id FROM `sub_franchisee` WHERE reference_no = ?
                                                                                                UNION ALL
                                                                                                SELECT institution_id AS suser_id FROM `institution` WHERE reference_no = ? ");
                                                                        $stmt3->execute([$bdm_id,$bdm_id]);
                                                                        $userCAs = $stmt3->fetchAll(PDO::FETCH_ASSOC);

                                                                        foreach($userCAs as $userCA){
                                                                            $userCAID = $userCA['suser_id'];
                                                                            // echo $userCA;

                                                                            $stmt4 = $conn->prepare("SELECT ca_travelagency_id AS user_id FROM ca_travelagency WHERE reference_no = ?
                                                                                                    UNION ALL
                                                                                                    SELECT institution_branch_manager_id AS user_id FROM institution_branch_manager WHERE reference_no = ?");
                                                                            $stmt4->execute([$userCA['suser_id'],$userCA['suser_id']]);
                                                                            $userCATAs = $stmt4->fetchAll(PDO::FETCH_ASSOC);

                                                                            foreach ($userCATAs as $userCATA) {
                                                                                $userTA = $userCATA['user_id'];
                                                                            //    echo $userCA.'=>'.$userTA.'</br>';

                                                                                $stmt5 = $conn->prepare("SELECT * FROM ca_customer WHERE ta_reference_no = ? AND (status ='2' OR status = '0') ");
                                                                                $stmt5->execute([$userCATA['user_id']]);
                                                                                $userCACUs = $stmt5->fetchAll(PDO::FETCH_ASSOC);

                                                                                foreach ($userCACUs as $userCACU) {
                                                                                    $userCU = $userCACU['id'];
                                                                                    // echo $userId.'=>'.$userCA.'=>'.$userTA.'=>'.$userCU.'</br>';

                                                                                    $bd= new DateTime($userCACU['date_of_birth']);
                                                                                    $bdate= $bd->format('d-m-Y');
                                                                                    $dt= new DateTime($userCACU['added_on']);
                                                                                    $datev= $dt->format('d-m-Y'); 
                                                                                    echo'<tr>
                                                                                        <td>'.$userCACU['id'].'</td>
                                                                                        <td>'.$userCACU['firstname'].' '.$userCACU['lastname'].'</td>
                                                                                        <td>
                                                                                            <p>'.$userCACU['reference_no'].' '.$userCACU['registrant'].'</p>
                                                                                            <p>'.$userCACU['ta_reference_no'].' '.$userCACU['ta_reference_name'].'</p>
                                                                                        </td>
                                                                                        <td>'.$userCACU['contact_no'].'</td>
                                                                                        <td>'.$datev.'</td>';
                                                                                        if($userCACU['status'] == '2')
                                                                                            echo'<td><span class="badge bg-warning">Pending</span></td>';
                                                                                        else{
                                                                                            echo'<td><span class="badge bg-danger">Deleted</span></td>';
                                                                                        }
                                                                                    echo'</tr>';
                                                                                }
                                                                            }   
                                                                        }
                                                                    }
                                                                }else if($userType == "25"){
                                                                    
                                                                    $stmt2 = $conn->prepare("SELECT business_mentor_id FROM business_mentor WHERE reference_no = ? AND user_type = '26' ");
                                                                    $stmt2->execute([$userId]);
                                                                    $userBMS = $stmt2->fetchAll(PDO::FETCH_ASSOC);
                                                                    //BM->TE->TC->TC->CU
                                                                    foreach ($userBMS as $userBM) {
                                                                        $bm_id = $userBM['business_mentor_id'];

                                                                        $stmt3 = $conn->prepare("SELECT corporate_agency_id FROM `corporate_agency` WHERE reference_no = ? ");
                                                                        $stmt3->execute([$bm_id]);
                                                                        $userCAs = $stmt3->fetchAll(PDO::FETCH_ASSOC);

                                                                        foreach($userCAs as $userCA){
                                                                            $userCAID = $userCA['corporate_agency_id'];
                                                                            // echo $userCA;

                                                                            $stmt4 = $conn->prepare("SELECT ca_travelagency_id FROM ca_travelagency WHERE reference_no = ?");
                                                                            $stmt4->execute([$userCA['corporate_agency_id']]);
                                                                            $userCATAs = $stmt4->fetchAll(PDO::FETCH_ASSOC);

                                                                            foreach ($userCATAs as $userCATA) {
                                                                                $userTA = $userCATA['ca_travelagency_id'];
                                                                            //    echo $userCA.'=>'.$userTA.'</br>';

                                                                                $stmt5 = $conn->prepare("SELECT * FROM ca_customer WHERE ta_reference_no = ? AND (status ='2' OR status = '0') ");
                                                                                $stmt5->execute([$userCATA['ca_travelagency_id']]);
                                                                                $userCACUs = $stmt5->fetchAll(PDO::FETCH_ASSOC);

                                                                                foreach ($userCACUs as $userCACU) {
                                                                                    $userCU = $userCACU['id'];
                                                                                    // echo $userId.'=>'.$userCA.'=>'.$userTA.'=>'.$userCU.'</br>';

                                                                                    $bd= new DateTime($userCACU['date_of_birth']);
                                                                                    $bdate= $bd->format('d-m-Y');
                                                                                    $dt= new DateTime($userCACU['added_on']);
                                                                                    $datev= $dt->format('d-m-Y'); 
                                                                                    echo'<tr>
                                                                                        <td>'.$userCACU['id'].'</td>
                                                                                        <td>'.$userCACU['firstname'].' '.$userCACU['lastname'].'</td>
                                                                                        <td>
                                                                                            <p>'.$userCACU['reference_no'].' '.$userCACU['registrant'].'</p>
                                                                                            <p>'.$userCACU['ta_reference_no'].' '.$userCACU['ta_reference_name'].'</p>
                                                                                        </td>
                                                                                        <td>'.$userCACU['contact_no'].'</td>
                                                                                        <td>'.$datev.'</td>';
                                                                                        if($userCACU['status'] == '2')
                                                                                            echo'<td><span class="badge bg-warning">Pending</span></td>';
                                                                                        else{
                                                                                            echo'<td><span class="badge bg-danger">Deleted</span></td>';
                                                                                        }
                                                                                    echo'</tr>';
                                                                                }
                                                                            }   
                                                                        }
                                                                        
                                                                        //direct TC with BM Ref
                                                                        $stmt4 = $conn->prepare("SELECT ca_travelagency_id FROM ca_travelagency WHERE reference_no = ?");
                                                                        $stmt4->execute([$bm_id]);
                                                                        $userCATAs = $stmt4->fetchAll(PDO::FETCH_ASSOC);

                                                                        foreach ($userCATAs as $userCATA) {
                                                                            $userTA = $userCATA['ca_travelagency_id'];
                                                                        //    echo $userCA.'=>'.$userTA.'</br>';

                                                                            $stmt5 = $conn->prepare("SELECT * FROM ca_customer WHERE ta_reference_no = ? AND (status ='2' OR status = '0') ");
                                                                            $stmt5->execute([$userCATA['ca_travelagency_id']]);
                                                                            $userCACUs = $stmt5->fetchAll(PDO::FETCH_ASSOC);

                                                                            foreach ($userCACUs as $userCACU) {
                                                                                $userCU = $userCACU['id'];
                                                                                // echo $userId.'=>'.$userCA.'=>'.$userTA.'=>'.$userCU.'</br>';

                                                                                $bd= new DateTime($userCACU['date_of_birth']);
                                                                                $bdate= $bd->format('d-m-Y');
                                                                                $dt= new DateTime($userCACU['added_on']);
                                                                                $datev= $dt->format('d-m-Y'); 
                                                                                echo'<tr>
                                                                                    <td>'.$userCACU['id'].'</td>
                                                                                    <td>'.$userCACU['firstname'].' '.$userCACU['lastname'].'</td>
                                                                                    <td>
                                                                                        <p>'.$userCACU['reference_no'].' '.$userCACU['registrant'].'</p>
                                                                                        <p>'.$userCACU['ta_reference_no'].' '.$userCACU['ta_reference_name'].'</p>
                                                                                    </td>
                                                                                    <td>'.$userCACU['contact_no'].'</td>
                                                                                    <td>'.$datev.'</td>';
                                                                                    if($userCACU['status'] == '2')
                                                                                        echo'<td><span class="badge bg-warning">Pending</span></td>';
                                                                                    else{
                                                                                        echo'<td><span class="badge bg-danger">Deleted</span></td>';
                                                                                    }
                                                                                echo'</tr>';
                                                                            }
                                                                        }
                                                                    }
                                                                    //MF/SF->F->TC->TC->CU
                                                                    $stmt2 = $conn->prepare("SELECT master_franchisee_id AS id FROM master_franchisee WHERE reference_no = ? AND user_type = '28'
                                                                                                UNION
                                                                                                SELECT sponsor_franchisee_id AS id FROM sponsor_franchisee WHERE reference_no = ? AND user_type = '30' ");
                                                                    $stmt2->execute([$userId,$userId]);
                                                                    $userBMS = $stmt2->fetchAll(PDO::FETCH_ASSOC);
                                                                    foreach ($userBMS as $userBM) {
                                                                        $bm_id = $userBM['id'];

                                                                        $stmt3 = $conn->prepare("SELECT sub_franchisee_id AS suser_id FROM `sub_franchisee` WHERE reference_no = ? 
                                                                                                UNION ALL
                                                                                                SELECT institution_id AS suser_id FROM `institution` WHERE reference_no = ?");
                                                                        $stmt3->execute([$bm_id,$bm_id]);
                                                                        $userCAs = $stmt3->fetchAll(PDO::FETCH_ASSOC);

                                                                        foreach($userCAs as $userCA){
                                                                            $userCAID = $userCA['suser_id'];
                                                                            // echo $userCA;

                                                                            $stmt4 = $conn->prepare("SELECT ca_travelagency_id AS user_id FROM ca_travelagency WHERE reference_no = ?
                                                                                                    UNION ALL
                                                                                                    SELECT institution_branch_manager_id AS user_id FROM institution_branch_manager WHERE reference_no = ?");
                                                                            $stmt4->execute([$userCA['suser_id'],$userCA['suser_id']]);
                                                                            $userCATAs = $stmt4->fetchAll(PDO::FETCH_ASSOC);

                                                                            foreach ($userCATAs as $userCATA) {
                                                                                $userTA = $userCATA['user_id'];
                                                                            //    echo $userCA.'=>'.$userTA.'</br>';

                                                                                $stmt5 = $conn->prepare("SELECT * FROM ca_customer WHERE ta_reference_no = ? AND (status ='2' OR status = '0') ");
                                                                                $stmt5->execute([$userCATA['user_id']]);
                                                                                $userCACUs = $stmt5->fetchAll(PDO::FETCH_ASSOC);

                                                                                foreach ($userCACUs as $userCACU) {
                                                                                    $userCU = $userCACU['id'];
                                                                                    // echo $userId.'=>'.$userCA.'=>'.$userTA.'=>'.$userCU.'</br>';

                                                                                    $bd= new DateTime($userCACU['date_of_birth']);
                                                                                    $bdate= $bd->format('d-m-Y');
                                                                                    $dt= new DateTime($userCACU['added_on']);
                                                                                    $datev= $dt->format('d-m-Y'); 
                                                                                    echo'<tr>
                                                                                        <td>'.$userCACU['id'].'</td>
                                                                                        <td>'.$userCACU['firstname'].' '.$userCACU['lastname'].'</td>
                                                                                        <td>
                                                                                            <p>'.$userCACU['reference_no'].' '.$userCACU['registrant'].'</p>
                                                                                            <p>'.$userCACU['ta_reference_no'].' '.$userCACU['ta_reference_name'].'</p>
                                                                                        </td>
                                                                                        <td>'.$userCACU['contact_no'].'</td>
                                                                                        <td>'.$datev.'</td>';
                                                                                        if($userCACU['status'] == '2')
                                                                                            echo'<td><span class="badge bg-warning">Pending</span></td>';
                                                                                        else{
                                                                                            echo'<td><span class="badge bg-danger">Deleted</span></td>';
                                                                                        }
                                                                                    echo'</tr>';
                                                                                }
                                                                            }   
                                                                        }
                                                                        
                                                                        //direct TC with MF/SF Ref
                                                                        $stmt4 = $conn->prepare("SELECT ca_travelagency_id FROM ca_travelagency WHERE reference_no = ?");
                                                                        $stmt4->execute([$bm_id]);
                                                                        $userCATAs = $stmt4->fetchAll(PDO::FETCH_ASSOC);

                                                                        foreach ($userCATAs as $userCATA) {
                                                                            $userTA = $userCATA['ca_travelagency_id'];
                                                                            //    echo $userCA.'=>'.$userTA.'</br>';

                                                                            $stmt5 = $conn->prepare("SELECT * FROM ca_customer WHERE ta_reference_no = ? AND (status ='2' OR status = '0') ");
                                                                            $stmt5->execute([$userCATA['ca_travelagency_id']]);
                                                                            $userCACUs = $stmt5->fetchAll(PDO::FETCH_ASSOC);

                                                                            foreach ($userCACUs as $userCACU) {
                                                                                $userCU = $userCACU['id'];
                                                                                // echo $userId.'=>'.$userCA.'=>'.$userTA.'=>'.$userCU.'</br>';

                                                                                $bd= new DateTime($userCACU['date_of_birth']);
                                                                                $bdate= $bd->format('d-m-Y');
                                                                                $dt= new DateTime($userCACU['added_on']);
                                                                                $datev= $dt->format('d-m-Y'); 
                                                                                echo'<tr>
                                                                                    <td>'.$userCACU['id'].'</td>
                                                                                    <td>'.$userCACU['firstname'].' '.$userCACU['lastname'].'</td>
                                                                                    <td>
                                                                                        <p>'.$userCACU['reference_no'].' '.$userCACU['registrant'].'</p>
                                                                                        <p>'.$userCACU['ta_reference_no'].' '.$userCACU['ta_reference_name'].'</p>
                                                                                    </td>
                                                                                    <td>'.$userCACU['contact_no'].'</td>
                                                                                    <td>'.$datev.'</td>';
                                                                                    if($userCACU['status'] == '2')
                                                                                        echo'<td><span class="badge bg-warning">Pending</span></td>';
                                                                                    else{
                                                                                        echo'<td><span class="badge bg-danger">Deleted</span></td>';
                                                                                    }
                                                                                echo'</tr>';
                                                                            }
                                                                        }
                                                                    }
                                                                    //direct BDM->TC->CU by BDM ref
                                                                    $stmt4 = $conn->prepare("SELECT ca_travelagency_id FROM ca_travelagency WHERE reference_no = ?");
                                                                    $stmt4->execute([$userId]);
                                                                    $userCATAs = $stmt4->fetchAll(PDO::FETCH_ASSOC);

                                                                    foreach ($userCATAs as $userCATA) {
                                                                        $userTA = $userCATA['ca_travelagency_id'];
                                                                    

                                                                        $stmt5 = $conn->prepare("SELECT * FROM ca_customer WHERE ta_reference_no = ? AND (status ='2' OR status = '0') ");
                                                                        $stmt5->execute([$userCATA['ca_travelagency_id']]);
                                                                        $userCACUs = $stmt5->fetchAll(PDO::FETCH_ASSOC);

                                                                        foreach ($userCACUs as $userCACU) {
                                                                            $userCU = $userCACU['id'];
                                                                            // echo $userId.'=>'.$userCA.'=>'.$userTA.'=>'.$userCU.'</br>';

                                                                            $bd= new DateTime($userCACU['date_of_birth']);
                                                                            $bdate= $bd->format('d-m-Y');
                                                                            $dt= new DateTime($userCACU['added_on']);
                                                                            $datev= $dt->format('d-m-Y'); 
                                                                            echo'<tr>
                                                                                <td>'.$userCACU['id'].'</td>
                                                                                <td>'.$userCACU['firstname'].' '.$userCACU['lastname'].'</td>
                                                                                <td>
                                                                                    <p>'.$userCACU['reference_no'].' '.$userCACU['registrant'].'</p>
                                                                                    <p>'.$userCACU['ta_reference_no'].' '.$userCACU['ta_reference_name'].'</p>
                                                                                </td>
                                                                                <td>'.$userCACU['contact_no'].'</td>
                                                                                <td>'.$datev.'</td>';
                                                                                if($userCACU['status'] == '2')
                                                                                    echo'<td><span class="badge bg-warning">Pending</span></td>';
                                                                                else{
                                                                                    echo'<td><span class="badge bg-danger">Deleted</span></td>';
                                                                                }
                                                                            echo'</tr>';
                                                                        }
                                                                    }
                                                                    //BDM->TE->TC->CU
                                                                    $stmt3 = $conn->prepare("SELECT corporate_agency_id FROM `corporate_agency` WHERE reference_no = ? ");
                                                                    $stmt3->execute([$userId]);
                                                                    $userCAs = $stmt3->fetchAll(PDO::FETCH_ASSOC);

                                                                    foreach($userCAs as $userCA){
                                                                        $userCAID = $userCA['corporate_agency_id'];
                                                                        // echo $userCA;

                                                                        $stmt4 = $conn->prepare("SELECT ca_travelagency_id FROM ca_travelagency WHERE reference_no = ?");
                                                                        $stmt4->execute([$userCA['corporate_agency_id']]);
                                                                        $userCATAs = $stmt4->fetchAll(PDO::FETCH_ASSOC);

                                                                        foreach ($userCATAs as $userCATA) {
                                                                            $userTA = $userCATA['ca_travelagency_id'];
                                                                        //    echo $userCA.'=>'.$userTA.'</br>';

                                                                            $stmt5 = $conn->prepare("SELECT * FROM ca_customer WHERE ta_reference_no = ? AND (status ='2' OR status = '0') ");
                                                                            $stmt5->execute([$userCATA['ca_travelagency_id']]);
                                                                            $userCACUs = $stmt5->fetchAll(PDO::FETCH_ASSOC);

                                                                            foreach ($userCACUs as $userCACU) {
                                                                                $userCU = $userCACU['id'];
                                                                                // echo $userId.'=>'.$userCA.'=>'.$userTA.'=>'.$userCU.'</br>';

                                                                                $bd= new DateTime($userCACU['date_of_birth']);
                                                                                $bdate= $bd->format('d-m-Y');
                                                                                $dt= new DateTime($userCACU['added_on']);
                                                                                $datev= $dt->format('d-m-Y'); 
                                                                                echo'<tr>
                                                                                    <td>'.$userCACU['id'].'</td>
                                                                                    <td>'.$userCACU['firstname'].' '.$userCACU['lastname'].'</td>
                                                                                    <td>
                                                                                        <p>'.$userCACU['reference_no'].' '.$userCACU['registrant'].'</p>
                                                                                        <p>'.$userCACU['ta_reference_no'].' '.$userCACU['ta_reference_name'].'</p>
                                                                                    </td>
                                                                                    <td>'.$userCACU['contact_no'].'</td>
                                                                                    <td>'.$datev.'</td>';
                                                                                    if($userCACU['status'] == '2')
                                                                                        echo'<td><span class="badge bg-warning">Pending</span></td>';
                                                                                    else{
                                                                                        echo'<td><span class="badge bg-danger">Deleted</span></td>';
                                                                                    }
                                                                                echo'</tr>';
                                                                            }
                                                                        }   
                                                                    }
                                                                    //BDM->F/I->TC/IBR->CU
                                                                    $stmt3 = $conn->prepare("SELECT sub_franchisee_id AS suser_id FROM `sub_franchisee` WHERE reference_no = ?
                                                                                            UNION ALL
                                                                                            SELECT institution_id AS suser_id FROM `institution` WHERE reference_no = ?");
                                                                    $stmt3->execute([$userId,$userId]);
                                                                    $userCAs = $stmt3->fetchAll(PDO::FETCH_ASSOC);

                                                                    foreach($userCAs as $userCA){
                                                                        $userCAID = $userCA['suser_id'];
                                                                        // echo $userCA;

                                                                        $stmt4 = $conn->prepare("SELECT ca_travelagency_id AS user_id FROM ca_travelagency WHERE reference_no = ?
                                                                                                UNION ALL
                                                                                                SELECT institution_branch_manager_id AS user_id FROM institution_branch_manager WHERE reference_no = ?");
                                                                        $stmt4->execute([$userCA['suser_id'],$userCA['suser_id']]);
                                                                        $userCATAs = $stmt4->fetchAll(PDO::FETCH_ASSOC);

                                                                        foreach ($userCATAs as $userCATA) {
                                                                            $userTA = $userCATA['user_id'];
                                                                        //    echo $userCA.'=>'.$userTA.'</br>';

                                                                            $stmt5 = $conn->prepare("SELECT * FROM ca_customer WHERE ta_reference_no = ? AND (status ='2' OR status = '0') ");
                                                                            $stmt5->execute([$userCATA['user_id']]);
                                                                            $userCACUs = $stmt5->fetchAll(PDO::FETCH_ASSOC);

                                                                            foreach ($userCACUs as $userCACU) {
                                                                                $userCU = $userCACU['id'];
                                                                                // echo $userId.'=>'.$userCA.'=>'.$userTA.'=>'.$userCU.'</br>';

                                                                                $bd= new DateTime($userCACU['date_of_birth']);
                                                                                $bdate= $bd->format('d-m-Y');
                                                                                $dt= new DateTime($userCACU['added_on']);
                                                                                $datev= $dt->format('d-m-Y'); 
                                                                                echo'<tr>
                                                                                    <td>'.$userCACU['id'].'</td>
                                                                                    <td>'.$userCACU['firstname'].' '.$userCACU['lastname'].'</td>
                                                                                    <td>
                                                                                        <p>'.$userCACU['reference_no'].' '.$userCACU['registrant'].'</p>
                                                                                        <p>'.$userCACU['ta_reference_no'].' '.$userCACU['ta_reference_name'].'</p>
                                                                                    </td>
                                                                                    <td>'.$userCACU['contact_no'].'</td>
                                                                                    <td>'.$datev.'</td>';
                                                                                    if($userCACU['status'] == '2')
                                                                                        echo'<td><span class="badge bg-warning">Pending</span></td>';
                                                                                    else{
                                                                                        echo'<td><span class="badge bg-danger">Deleted</span></td>';
                                                                                    }
                                                                                echo'</tr>';
                                                                            }
                                                                        }   
                                                                    }
                                                                    
                                                                }else if($userType == "26" || $userType =="28" || $userType == "30"){
                                                                    if ($userType == "28" || $userType == "30") {
                                                                        $stmt2 = $conn->prepare("SELECT sub_franchisee_id AS suser_id FROM `sub_franchisee` WHERE reference_no = ?
                                                                                                UNION ALL
                                                                                                SELECT institution_id AS suser_id FROM `institution` WHERE reference_no = ? ");
                                                                        $stmt2->execute([$userId,$userId]);
                                                                    }else{
                                                                        $stmt2 = $conn->prepare("SELECT corporate_agency_id FROM `corporate_agency` WHERE reference_no = ? ");
                                                                        $stmt2->execute([$userId]);
                                                                    }    
                                                                    
                                                                    $referrals = $stmt2->fetchAll(PDO::FETCH_ASSOC);

                                                                    foreach($referrals as $referral){
                                                                        $userCA = ($userType == "28"||$userType == "30")?$referral['suser_id']:$referral['corporate_agency_id'];
                                                                        // echo $userCA;

                                                                        $stmt4 = $conn->prepare("SELECT ca_travelagency_id AS user_id FROM ca_travelagency WHERE reference_no = ?");
                                                                        $stmt4->execute([$userCA]);
                                                                        $userCATAs = $stmt4->fetchAll(PDO::FETCH_ASSOC);

                                                                        foreach ($userCATAs as $userCATA) {
                                                                            $userTA = $userCATA['user_id'];
                                                                            //    echo $userCA.'=>'.$userTA.'</br>';

                                                                            $stmt5 = $conn->prepare("SELECT * FROM ca_customer WHERE ta_reference_no = ? AND (status ='2' OR status = '0') ");
                                                                            $stmt5->execute([$userCATA['user_id']]);
                                                                            $userCACUs = $stmt5->fetchAll(PDO::FETCH_ASSOC);

                                                                            foreach ($userCACUs as $userCACU) {
                                                                                $userCU = $userCACU['id'];
                                                                                // echo $userId.'=>'.$userCA.'=>'.$userTA.'=>'.$userCU.'</br>';

                                                                                $bd= new DateTime($userCACU['date_of_birth']);
                                                                                $bdate= $bd->format('d-m-Y');
                                                                                $dt= new DateTime($userCACU['added_on']);
                                                                                $datev= $dt->format('d-m-Y'); 
                                                                                echo'<tr>
                                                                                    <td>'.$userCACU['id'].'</td>
                                                                                    <td>'.$userCACU['firstname'].' '.$userCACU['lastname'].'</td>
                                                                                    <td>
                                                                                        <p>'.$userCACU['reference_no'].' '.$userCACU['registrant'].'</p>
                                                                                        <p>'.$userCACU['ta_reference_no'].' '.$userCACU['ta_reference_name'].'</p>
                                                                                    </td>
                                                                                    <td>'.$userCACU['contact_no'].'</td>
                                                                                    <td>'.$datev.'</td>';
                                                                                    if($userCACU['status'] == '2'){
                                                                                        echo'<td><span class="badge bg-warning">Pending</span></td>';
                                                                                    //     <td>
                                                                                    //     <div class="dropdown d-inline-block">
                                                                                    //         <button class="btn btn-soft-secondary btn-sm dropdown" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                                                    //             <i class="ri-more-fill align-middle"></i>
                                                                                    //         </button>
                                                                                    //         <ul class="dropdown-menu dropdown-menu-end">
                                                                                    //             <!-- <li><a class="dropdown-item edit-item-btn" onclick=\'confirmfunc("' .$userCACU["id"]. '","' .$userCACU["email"]. '")\'><i class="ri-checkbox-circle-fill align-bottom me-2 text-muted"></i> Confirm</a></li> -->
                                                                                    //             <li><a class="dropdown-item edit-item-btn" onclick=\'editfunc("' .$userCACU["id"]. '","' .$userCACU["country"]. '","' .$userCACU["state"]. '","' .$userCACU["city"]. '","pending")\'><i class="ri-pencil-fill align-bottom me-2 text-muted"></i> Edit</a></li>
                                                                                    //             <li><a class="dropdown-item remove-item-btn" onclick=\'deletefunc("'.$userCACU["id"].'","","pending")\'><i class="ri-delete-bin-fill align-bottom me-2 text-muted"></i> Delete</a></li>
                                                                                    //         </ul>
                                                                                    //     </div>
                                                                                    // </td>';
                                                                                    }else{
                                                                                        echo'<td><span class="badge bg-danger">Deleted</span></td>';
                                                                                    //     <td>
                                                                                    //     <div class="dropdown d-inline-block">
                                                                                    //         <button class="btn btn-soft-secondary btn-sm dropdown" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                                                    //             <i class="ri-more-fill align-middle"></i>
                                                                                    //         </button>
                                                                                    //         <ul class="dropdown-menu dropdown-menu-end">
                                                                                    //             <li><a class="dropdown-item remove-item-btn" onclick=\'deletefunc("'.$userCACU["id"].'","","deleted")\'><i class="ri-checkbox-circle-fill align-bottom me-2 text-muted"></i> Activate</a></li>
                                                                                    //         </ul>
                                                                                    //     </div>
                                                                                    // </td>';
                                                                                    }
                                                                                echo'</tr>';
                                                                            }
                                                                        }   
                                                                    }
                                                                    
                                                                    //direct TC with BM/MF Ref
                                                                    $stmt4 = $conn->prepare("SELECT ca_travelagency_id FROM ca_travelagency WHERE reference_no = ?");
                                                                    $stmt4->execute([$userId]);
                                                                    $userCATAs = $stmt4->fetchAll(PDO::FETCH_ASSOC);

                                                                    foreach ($userCATAs as $userCATA) {
                                                                        $userTA = $userCATA['ca_travelagency_id'];
                                                                        //    echo $userCA.'=>'.$userTA.'</br>';

                                                                        $stmt5 = $conn->prepare("SELECT * FROM ca_customer WHERE ta_reference_no = ? AND (status ='2' OR status = '0') ");
                                                                        $stmt5->execute([$userCATA['ca_travelagency_id']]);
                                                                        $userCACUs = $stmt5->fetchAll(PDO::FETCH_ASSOC);

                                                                        foreach ($userCACUs as $userCACU) {
                                                                            $userCU = $userCACU['id'];
                                                                            // echo $userId.'=>'.$userCA.'=>'.$userTA.'=>'.$userCU.'</br>';

                                                                            $bd= new DateTime($userCACU['date_of_birth']);
                                                                            $bdate= $bd->format('d-m-Y');
                                                                            $dt= new DateTime($userCACU['added_on']);
                                                                            $datev= $dt->format('d-m-Y'); 
                                                                            echo'<tr>
                                                                                <td>'.$userCACU['id'].'</td>
                                                                                <td>'.$userCACU['firstname'].' '.$userCACU['lastname'].'</td>
                                                                                <td>
                                                                                    <p>'.$userCACU['reference_no'].' '.$userCACU['registrant'].'</p>
                                                                                    <p>'.$userCACU['ta_reference_no'].' '.$userCACU['ta_reference_name'].'</p>
                                                                                </td>
                                                                                <td>'.$userCACU['contact_no'].'</td>
                                                                                <td>'.$datev.'</td>';
                                                                                if($userCACU['status'] == '2'){
                                                                                    echo'<td><span class="badge bg-warning">Pending</span></td>';
                                                                                //     <td>
                                                                                //     <div class="dropdown d-inline-block">
                                                                                //         <button class="btn btn-soft-secondary btn-sm dropdown" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                                                //             <i class="ri-more-fill align-middle"></i>
                                                                                //         </button>
                                                                                //         <ul class="dropdown-menu dropdown-menu-end">
                                                                                //             <!-- <li><a class="dropdown-item edit-item-btn" onclick=\'confirmfunc("' .$userCACU["id"]. '","' .$userCACU["email"]. '")\'><i class="ri-checkbox-circle-fill align-bottom me-2 text-muted"></i> Confirm</a></li> -->
                                                                                //             <li><a class="dropdown-item edit-item-btn" onclick=\'editfunc("' .$userCACU["id"]. '","' .$userCACU["country"]. '","' .$userCACU["state"]. '","' .$userCACU["city"]. '","pending")\'><i class="ri-pencil-fill align-bottom me-2 text-muted"></i> Edit</a></li>
                                                                                //             <li><a class="dropdown-item remove-item-btn" onclick=\'deletefunc("'.$userCACU["id"].'","","pending")\'><i class="ri-delete-bin-fill align-bottom me-2 text-muted"></i> Delete</a></li>
                                                                                //         </ul>
                                                                                //     </div>
                                                                                // </td>';
                                                                                }else{
                                                                                    echo'<td><span class="badge bg-danger">Deleted</span></td>';
                                                                                //     <td>
                                                                                //     <div class="dropdown d-inline-block">
                                                                                //         <button class="btn btn-soft-secondary btn-sm dropdown" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                                                //             <i class="ri-more-fill align-middle"></i>
                                                                                //         </button>
                                                                                //         <ul class="dropdown-menu dropdown-menu-end">
                                                                                //             <li><a class="dropdown-item remove-item-btn" onclick=\'deletefunc("'.$userCACU["id"].'","","deleted")\'><i class="ri-checkbox-circle-fill align-bottom me-2 text-muted"></i> Activate</a></li>
                                                                                //         </ul>
                                                                                //     </div>
                                                                                // </td>';
                                                                                }
                                                                            echo'</tr>';
                                                                        }
                                                                    }
                                                                }else if($userType == "16" || $userType == "29" || $userType == "32"){
                                                                    
                                                                    $stmt4 = $conn->prepare("SELECT ca_travelagency_id AS user_id FROM ca_travelagency WHERE reference_no = ?
                                                                                            UNION ALL
                                                                                            SELECT institution_branch_manager_id AS user_id FROM institution_branch_manager WHERE reference_no = ?");
                                                                    $stmt4->execute([$userId,$userId]);
                                                                    $userCATAs = $stmt4->fetchAll(PDO::FETCH_ASSOC);

                                                                    foreach ($userCATAs as $userCATA) {
                                                                        $userTA = $userCATA['user_id'];
                                                                        // echo $userTA.'</br>';

                                                                        $stmt5 = $conn->prepare("SELECT * FROM ca_customer WHERE ta_reference_no = ? AND (status='2' OR status = '0')");
                                                                        $stmt5->execute([$userCATA['user_id']]);
                                                                        $userCACUs = $stmt5->fetchAll(PDO::FETCH_ASSOC);

                                                                        foreach ($userCACUs as $userCACU) {
                                                                            $userCU = $userCACU['id'];
                                                                            // echo $userTA.'=>'.$userCU.'</br>';

                                                                            $bd= new DateTime($userCACU['date_of_birth']);
                                                                            $bdate= $bd->format('d-m-Y');
                                                                            $dt= new DateTime($userCACU['added_on']);
                                                                            $datev= $dt->format('d-m-Y'); 
                                                                            echo'<tr>
                                                                                <td>'.$userCACU['id'].'</td>
                                                                                <td>'.$userCACU['firstname'].' '.$userCACU['lastname'].'</td>
                                                                                <td>
                                                                                    <p>'.$userCACU['reference_no'].' '.$userCACU['registrant'].'</p>
                                                                                    <p>'.$userCACU['ta_reference_no'].' '.$userCACU['ta_reference_name'].'</p>
                                                                                </td>
                                                                                <td>'.$userCACU['contact_no'].'</td>
                                                                                <td>'.$datev.'</td>';
                                                                                if($userCACU['status'] == '2')
                                                                                    echo'<td><span class="badge bg-warning">Pending</span></td>';
                                                                                else{
                                                                                    echo'<td><span class="badge bg-danger">Delected</span></td>';
                                                                                }
                                                                            echo'</tr>';
                                                                        }
                                                                    }
                                                                }else if($userType == "11" || $userType == "33"){
                                                                    $sql = "SELECT * FROM `ca_customer` WHERE ta_reference_no = '$userId' AND (status = '2' OR status = '0') ";
                                                                    $stmt = $conn -> prepare($sql);
                                                                    $stmt -> execute();
                                                                    $stmt -> setFetchMode(PDO::FETCH_ASSOC);
                                                                    if($stmt -> rowCount()>0){
                                                                        foreach(($stmt -> fetchAll()) as $key => $row){
                                                                            $bd= new DateTime($row['date_of_birth']);
                                                                            $bdate= $bd->format('d-m-Y');
                                                                            $dt= new DateTime($row['added_on']);
                                                                            $datev= $dt->format('d-m-Y'); 
                                                                            echo'<tr>
                                                                                <td>'.$row['id'].'</td>
                                                                                <td>'.$row['firstname'].' '.$row['lastname'].'</td>
                                                                                <td>
                                                                                    <p>'.$row['ta_reference_no'].' '.$row['ta_reference_name'].'</p>
                                                                                    <p>'.$row['reference_no'].' '.$row['registrant'].'</p>
                                                                                </td>
                                                                                <td>'.$row['contact_no'].'</td>
                                                                                <td>'.$datev.'</td>';
                                                                                if($row['status'] == '2')
                                                                                    echo'<td><span class="badge bg-warning">Pending</span></td>';
                                                                                else{
                                                                                    echo'<td><span class="badge bg-danger">Deleted</span></td>';
                                                                                }
                                                                            echo'</tr>';
                                                                        }
                                                                    }
                                                                }else if($userType == "10"){
                                                                    $sql = "SELECT * FROM `ca_customer` WHERE reference_no = '$userId' AND (status = '2' OR status = '0') ";
                                                                    $stmt = $conn -> prepare($sql);
                                                                    $stmt -> execute();
                                                                    $stmt -> setFetchMode(PDO::FETCH_ASSOC);
                                                                    if($stmt -> rowCount()>0){
                                                                        foreach(($stmt -> fetchAll()) as $key => $row){
                                                                            $bd= new DateTime($row['date_of_birth']);
                                                                            $bdate= $bd->format('d-m-Y');
                                                                            $dt= new DateTime($row['added_on']);
                                                                            $datev= $dt->format('d-m-Y'); 
                                                                            echo'<tr>
                                                                                <td>'.$row['id'].'</td>
                                                                                <td>'.$row['firstname'].' '.$row['lastname'].'</td>
                                                                                <td>
                                                                                    <p>'.$row['ta_reference_no'].' '.$row['ta_reference_name'].'</p>
                                                                                    <p>'.$row['reference_no'].' '.$row['registrant'].'</p>
                                                                                </td>
                                                                                <td>'.$row['contact_no'].'</td>
                                                                                <td>'.$datev.'</td>';
                                                                                if($row['status'] == '2')
                                                                                    echo'<td><span class="badge bg-warning">Pending</span></td>';
                                                                                else{
                                                                                    echo'<td><span class="badge bg-danger">Deleted</span></td>';
                                                                                }
                                                                            echo'</tr>';
                                                                        }
                                                                    }
                                                                }else if($userType == "31"){
                                                                    
                                                                    //MF/SF->F->TC->TC->CU
                                                                    $stmt2 = $conn->prepare("SELECT master_franchisee_id AS id FROM master_franchisee WHERE reference_no = ? AND user_type = '28'
                                                                                                UNION
                                                                                                SELECT sponsor_franchisee_id AS id FROM sponsor_franchisee WHERE reference_no = ? AND user_type = '30' ");
                                                                    $stmt2->execute([$userId,$userId]);
                                                                    $userBMS = $stmt2->fetchAll(PDO::FETCH_ASSOC);
                                                                    foreach ($userBMS as $userBM) {
                                                                        $bm_id = $userBM['id'];

                                                                        $stmt3 = $conn->prepare("SELECT sub_franchisee_id AS suser_id FROM `sub_franchisee` WHERE reference_no = ?
                                                                                                UNION ALL
                                                                                                SELECT institution_id AS suser_id FROM `institution` WHERE reference_no = ? ");
                                                                        $stmt3->execute([$bm_id,$bm_id]);
                                                                        $userCAs = $stmt3->fetchAll(PDO::FETCH_ASSOC);

                                                                        foreach($userCAs as $userCA){
                                                                            $userCAID = $userCA['suser_id'];
                                                                            // echo $userCA;

                                                                            $stmt4 = $conn->prepare("SELECT ca_travelagency_id AS user_id FROM ca_travelagency WHERE reference_no = ?
                                                                                                    UNION ALL
                                                                                                    SELECT institution_branch_manager_id AS user_id FROM institution_branch_manager WHERE reference_no = ?");
                                                                            $stmt4->execute([$userCA['suser_id'],$userCA['suser_id']]);
                                                                            $userCATAs = $stmt4->fetchAll(PDO::FETCH_ASSOC);

                                                                            foreach ($userCATAs as $userCATA) {
                                                                                $userTA = $userCATA['user_id'];
                                                                            //    echo $userCA.'=>'.$userTA.'</br>';

                                                                                $stmt5 = $conn->prepare("SELECT * FROM ca_customer WHERE ta_reference_no = ? AND (status ='2' OR status = '0') ");
                                                                                $stmt5->execute([$userCATA['user_id']]);
                                                                                $userCACUs = $stmt5->fetchAll(PDO::FETCH_ASSOC);

                                                                                foreach ($userCACUs as $userCACU) {
                                                                                    $userCU = $userCACU['id'];
                                                                                    // echo $userId.'=>'.$userCA.'=>'.$userTA.'=>'.$userCU.'</br>';

                                                                                    $bd= new DateTime($userCACU['date_of_birth']);
                                                                                    $bdate= $bd->format('d-m-Y');
                                                                                    $dt= new DateTime($userCACU['added_on']);
                                                                                    $datev= $dt->format('d-m-Y'); 
                                                                                    echo'<tr>
                                                                                        <td>'.$userCACU['id'].'</td>
                                                                                        <td>'.$userCACU['firstname'].' '.$userCACU['lastname'].'</td>
                                                                                        <td>
                                                                                            <p>'.$userCACU['reference_no'].' '.$userCACU['registrant'].'</p>
                                                                                            <p>'.$userCACU['ta_reference_no'].' '.$userCACU['ta_reference_name'].'</p>
                                                                                        </td>
                                                                                        <td>'.$userCACU['contact_no'].'</td>
                                                                                        <td>'.$datev.'</td>';
                                                                                        if($userCACU['status'] == '2')
                                                                                            echo'<td><span class="badge bg-warning">Pending</span></td>';
                                                                                        else{
                                                                                            echo'<td><span class="badge bg-danger">Deleted</span></td>';
                                                                                        }
                                                                                    echo'</tr>';
                                                                                }
                                                                            }   
                                                                        }
                                                                        
                                                                        //direct TC with BM Ref
                                                                        $stmt4 = $conn->prepare("SELECT ca_travelagency_id FROM ca_travelagency WHERE reference_no = ?");
                                                                        $stmt4->execute([$bm_id]);
                                                                        $userCATAs = $stmt4->fetchAll(PDO::FETCH_ASSOC);

                                                                        foreach ($userCATAs as $userCATA) {
                                                                            $userTA = $userCATA['ca_travelagency_id'];
                                                                            //    echo $userCA.'=>'.$userTA.'</br>';

                                                                            $stmt5 = $conn->prepare("SELECT * FROM ca_customer WHERE ta_reference_no = ? AND (status ='2' OR status = '0') ");
                                                                            $stmt5->execute([$userCATA['ca_travelagency_id']]);
                                                                            $userCACUs = $stmt5->fetchAll(PDO::FETCH_ASSOC);

                                                                            foreach ($userCACUs as $userCACU) {
                                                                                $userCU = $userCACU['id'];
                                                                                // echo $userId.'=>'.$userCA.'=>'.$userTA.'=>'.$userCU.'</br>';

                                                                                $bd= new DateTime($userCACU['date_of_birth']);
                                                                                $bdate= $bd->format('d-m-Y');
                                                                                $dt= new DateTime($userCACU['added_on']);
                                                                                $datev= $dt->format('d-m-Y'); 
                                                                                echo'<tr>
                                                                                    <td>'.$userCACU['id'].'</td>
                                                                                    <td>'.$userCACU['firstname'].' '.$userCACU['lastname'].'</td>
                                                                                    <td>
                                                                                        <p>'.$userCACU['reference_no'].' '.$userCACU['registrant'].'</p>
                                                                                        <p>'.$userCACU['ta_reference_no'].' '.$userCACU['ta_reference_name'].'</p>
                                                                                    </td>
                                                                                    <td>'.$userCACU['contact_no'].'</td>
                                                                                    <td>'.$datev.'</td>';
                                                                                    if($userCACU['status'] == '2')
                                                                                        echo'<td><span class="badge bg-warning">Pending</span></td>';
                                                                                    else{
                                                                                        echo'<td><span class="badge bg-danger">Deleted</span></td>';
                                                                                    }
                                                                                echo'</tr>';
                                                                            }
                                                                        }
                                                                    }
                                                                    //direct RM->TC->CU by BDM ref
                                                                    $stmt4 = $conn->prepare("SELECT ca_travelagency_id FROM ca_travelagency WHERE reference_no = ?");
                                                                    $stmt4->execute([$userId]);
                                                                    $userCATAs = $stmt4->fetchAll(PDO::FETCH_ASSOC);

                                                                    foreach ($userCATAs as $userCATA) {
                                                                        $userTA = $userCATA['ca_travelagency_id'];
                                                                    

                                                                        $stmt5 = $conn->prepare("SELECT * FROM ca_customer WHERE ta_reference_no = ? AND (status ='2' OR status = '0') ");
                                                                        $stmt5->execute([$userCATA['ca_travelagency_id']]);
                                                                        $userCACUs = $stmt5->fetchAll(PDO::FETCH_ASSOC);

                                                                        foreach ($userCACUs as $userCACU) {
                                                                            $userCU = $userCACU['id'];
                                                                            // echo $userId.'=>'.$userCA.'=>'.$userTA.'=>'.$userCU.'</br>';

                                                                            $bd= new DateTime($userCACU['date_of_birth']);
                                                                            $bdate= $bd->format('d-m-Y');
                                                                            $dt= new DateTime($userCACU['added_on']);
                                                                            $datev= $dt->format('d-m-Y'); 
                                                                            echo'<tr>
                                                                                <td>'.$userCACU['id'].'</td>
                                                                                <td>'.$userCACU['firstname'].' '.$userCACU['lastname'].'</td>
                                                                                <td>
                                                                                    <p>'.$userCACU['reference_no'].' '.$userCACU['registrant'].'</p>
                                                                                    <p>'.$userCACU['ta_reference_no'].' '.$userCACU['ta_reference_name'].'</p>
                                                                                </td>
                                                                                <td>'.$userCACU['contact_no'].'</td>
                                                                                <td>'.$datev.'</td>';
                                                                                if($userCACU['status'] == '2')
                                                                                    echo'<td><span class="badge bg-warning">Pending</span></td>';
                                                                                else{
                                                                                    echo'<td><span class="badge bg-danger">Deleted</span></td>';
                                                                                }
                                                                            echo'</tr>';
                                                                        }
                                                                    }
                                                                    //RM->F/I->TC/IBR->CU
                                                                    $stmt3 = $conn->prepare("SELECT sub_franchisee_id AS suser_id FROM `sub_franchisee` WHERE reference_no = ?
                                                                                            UNION ALL
                                                                                            SELECT institution_id AS suser_id FROM institution WHERE reference_no = ? ");
                                                                    $stmt3->execute([$userId,$userId]);
                                                                    $userCAs = $stmt3->fetchAll(PDO::FETCH_ASSOC);

                                                                    foreach($userCAs as $userCA){
                                                                        $userCAID = $userCA['suser_id'];
                                                                        // echo $userCA;

                                                                        $stmt4 = $conn->prepare("SELECT ca_travelagency_id AS user_id FROM ca_travelagency WHERE reference_no = ?
                                                                                                UNION ALL
                                                                                                SELECT institution_branch_manager_id AS user_id FROM institution_branch_manager WHERE reference_no = ?");
                                                                        $stmt4->execute([$userCA['suser_id'],$userCA['suser_id']]);
                                                                        $userCATAs = $stmt4->fetchAll(PDO::FETCH_ASSOC);

                                                                        foreach ($userCATAs as $userCATA) {
                                                                            $userTA = $userCATA['user_id'];
                                                                        //    echo $userCA.'=>'.$userTA.'</br>';

                                                                            $stmt5 = $conn->prepare("SELECT * FROM ca_customer WHERE ta_reference_no = ? AND (status ='2' OR status = '0') ");
                                                                            $stmt5->execute([$userCATA['user_id']]);
                                                                            $userCACUs = $stmt5->fetchAll(PDO::FETCH_ASSOC);

                                                                            foreach ($userCACUs as $userCACU) {
                                                                                $userCU = $userCACU['id'];
                                                                                // echo $userId.'=>'.$userCA.'=>'.$userTA.'=>'.$userCU.'</br>';

                                                                                $bd= new DateTime($userCACU['date_of_birth']);
                                                                                $bdate= $bd->format('d-m-Y');
                                                                                $dt= new DateTime($userCACU['added_on']);
                                                                                $datev= $dt->format('d-m-Y'); 
                                                                                echo'<tr>
                                                                                    <td>'.$userCACU['id'].'</td>
                                                                                    <td>'.$userCACU['firstname'].' '.$userCACU['lastname'].'</td>
                                                                                    <td>
                                                                                        <p>'.$userCACU['reference_no'].' '.$userCACU['registrant'].'</p>
                                                                                        <p>'.$userCACU['ta_reference_no'].' '.$userCACU['ta_reference_name'].'</p>
                                                                                    </td>
                                                                                    <td>'.$userCACU['contact_no'].'</td>
                                                                                    <td>'.$datev.'</td>';
                                                                                    if($userCACU['status'] == '2')
                                                                                        echo'<td><span class="badge bg-warning">Pending</span></td>';
                                                                                    else{
                                                                                        echo'<td><span class="badge bg-danger">Deleted</span></td>';
                                                                                    }
                                                                                echo'</tr>';
                                                                            }
                                                                        }   
                                                                    }
                                                                    
                                                                }
                                                            ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="card">
                                                <div class="card-header">
                                                    <h5 class="card-title mb-0">Registered List</h5>
                                                </div>
                                                <div class="card-body">
                                                    <table id="example-dataTable-2" class="table table-bordered dt-responsive nowrap table-striped align-middle" style="width:100%">
                                                        <thead>
                                                            <tr>
                                                                <th data-ordering="false">Customer ID & Name</th>
                                                                <th data-ordering="false">Reference ID & Name</th>
                                                                <th data-ordering="false">Type/Complemetory</th>
                                                                <th data-ordering="false">Phone</th>
                                                                <th data-ordering="false">Joining Date</th>
                                                                <th data-ordering="false">Status</th>
                                                                <?php if( $userType == "11" || $userType == "10" || $userType == '33'){ ?>
                                                                    <th data-ordering="false">Action</th>
                                                                <?php } ?>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php

                                                                if($userType == "24"){
                                                                    $stmt = $conn -> prepare("SELECT employee_id FROM `employees` WHERE reporting_manager = ? AND user_type = '25' ");
                                                                    $stmt -> execute([$userId]);
                                                                    $userBDMS = $stmt -> fetchAll(PDO::FETCH_ASSOC);
                                                                    
                                                                    foreach( $userBDMS as $userBDM ){
                                                                        $bdm_id = $userBDM['employee_id'];
                                                                        //BM/MF/SF->TE/F/I->TC/IBR->CU
                                                                        $stmt2 = $conn->prepare("SELECT business_mentor_id AS id FROM business_mentor WHERE reference_no = ? AND user_type = '26' 
                                                                                                UNION ALL
                                                                                                SELECT master_franchisee_id AS id FROM master_franchisee WHERE reference_no = ? AND user_type = '28'
                                                                                                UNION ALL
                                                                                                SELECT sponsor_franchisee_id AS id FROM sponsor_franchisee WHERE reference_no = ? AND user_type = '30' ");
                                                                        $stmt2->execute([$bdm_id,$bdm_id,$bdm_id]);
                                                                        $userBMS = $stmt2->fetchAll(PDO::FETCH_ASSOC);
                                                                    
                                                                        foreach ($userBMS as $userBM) {
                                                                            $bm_id = $userBM['id'];

                                                                            $stmt3 = $conn->prepare("SELECT corporate_agency_id AS suser_id FROM `corporate_agency` WHERE reference_no = ?
                                                                                                    UNION ALL
                                                                                                    SELECT institution_id AS suser_id FROM `institution` WHERE reference_no = ? 
                                                                                                    UNION ALL
                                                                                                    SELECT sub_franchisee_id AS suser_id FROM `sub_franchisee` WHERE reference_no = ?");
                                                                            $stmt3->execute([$bm_id, $bm_id, $bm_id]);
                                                                            $userCAs = $stmt3->fetchAll(PDO::FETCH_ASSOC);

                                                                            foreach($userCAs as $userCA){
                                                                                $userCAID = $userCA['suser_id'];
                                                                                // echo $userCA;

                                                                                $stmt4 = $conn->prepare("SELECT ca_travelagency_id FROM ca_travelagency WHERE reference_no = ?
                                                                                                        UNION ALL
                                                                                                        SELECT institution_branch_manager_id AS user_id FROM institution_branch_manager WHERE reference_no = ?");
                                                                                $stmt4->execute([$userCA['suser_id'],$userCA['suser_id']]);
                                                                                $userCATAs = $stmt4->fetchAll(PDO::FETCH_ASSOC);

                                                                                foreach ($userCATAs as $userCATA) {
                                                                                    $userTA = $userCATA['user_id'];
                                                                                    //    echo $userCA.'=>'.$userTA.'</br>';

                                                                                    $stmt5 = $conn->prepare("SELECT * FROM ca_customer WHERE ta_reference_no = ? AND (status ='1' OR status = '3') ");
                                                                                    $stmt5->execute([$userCATA['user_id']]);
                                                                                    $userCACUs = $stmt5->fetchAll(PDO::FETCH_ASSOC);

                                                                                    foreach ($userCACUs as $userCACU) {
                                                                                        $userCU = $userCACU['id'];
                                                                                        // echo $userId.'=>'.$userCA.'=>'.$userTA.'=>'.$userCU.'</br>';
                                                                                        $comp_chek = $userCACU['comp_chek'] == '1' ? 'complimentary' : 'Noncomplimentary'; 
                                                                                        $bd= new DateTime($userCACU['date_of_birth']);
                                                                                        $bdate= $bd->format('d-m-Y');
                                                                                        $dt= new DateTime($userCACU['register_date']);
                                                                                        $datev= $dt->format('d-m-Y'); 
                                                                                        echo'<tr>
                                                                                            <td>
                                                                                                <p>'.$userCACU['ca_customer_id'].'</p>
                                                                                                <p>'.$userCACU['firstname'].' '.$userCACU['lastname'].'</p>
                                                                                            </td>
                                                                                            <td>
                                                                                                <p>'.$userCACU['reference_no'].' '.$userCACU['registrant'].'</p>
                                                                                                <p>'.$userCACU['ta_reference_no'].' '.$userCACU['ta_reference_name'].'</p>
                                                                                            </td>
                                                                                            <td>
                                                                                                <p class="mb-0">'.$userCACU['customer_type'].'</p>
                                                                                                <p class="mb-0">'.$comp_chek.'</p>
                                                                                            </td>
                                                                                            <td>'.$userCACU['contact_no'].'</td>
                                                                                            <td>'.$datev.'</td>';
                                                                                            if($userCACU['status'] == '1')
                                                                                                echo'<td><span class="badge bg-success">Active</span></td>';
                                                                                            else{
                                                                                                echo'<td><span class="badge bg-danger">Deactive</span></td>';
                                                                                            }
                                                                                        echo'</tr>';
                                                                                    }
                                                                                }   
                                                                            }
                                                                            
                                                                            //direct TC with BM/MF Ref
                                                                            $stmt4 = $conn->prepare("SELECT ca_travelagency_id FROM ca_travelagency WHERE reference_no = ?");
                                                                            $stmt4->execute([$bm_id]);
                                                                            $userCATAs = $stmt4->fetchAll(PDO::FETCH_ASSOC);

                                                                            foreach ($userCATAs as $userCATA) {
                                                                                $userTA = $userCATA['ca_travelagency_id'];

                                                                                $stmt5 = $conn->prepare("SELECT * FROM ca_customer WHERE ta_reference_no = ? AND (status ='1' OR status = '3') ");
                                                                                $stmt5->execute([$userCATA['ca_travelagency_id']]);
                                                                                $userCACUs = $stmt5->fetchAll(PDO::FETCH_ASSOC);

                                                                                foreach ($userCACUs as $userCACU) {
                                                                                    $userCU = $userCACU['id'];
                                                                                    // echo $userId.'=>'.$userCA.'=>'.$userTA.'=>'.$userCU.'</br>';
                                                                                    $comp_chek = $userCACU['comp_chek'] == '1' ? 'complimentary' : 'Noncomplimentary'; 
                                                                                    $bd= new DateTime($userCACU['date_of_birth']);
                                                                                    $bdate= $bd->format('d-m-Y');
                                                                                    $dt= new DateTime($userCACU['register_date']);
                                                                                    $datev= $dt->format('d-m-Y'); 
                                                                                    echo'<tr>
                                                                                        <td>
                                                                                            <p>'.$userCACU['ca_customer_id'].'</p>
                                                                                            <p>'.$userCACU['firstname'].' '.$userCACU['lastname'].'</p>
                                                                                        </td>
                                                                                        <td>
                                                                                            <p>'.$userCACU['reference_no'].' '.$userCACU['registrant'].'</p>
                                                                                            <p>'.$userCACU['ta_reference_no'].' '.$userCACU['ta_reference_name'].'</p>
                                                                                        </td>
                                                                                        <td>
                                                                                            <p class="mb-0">'.$userCACU['customer_type'].'</p>
                                                                                            <p class="mb-0">'.$comp_chek.'</p>
                                                                                        </td>
                                                                                        <td>'.$userCACU['contact_no'].'</td>
                                                                                        <td>'.$datev.'</td>';
                                                                                        if($userCACU['status'] == '1')
                                                                                            echo'<td><span class="badge bg-success">Active</span></td>';
                                                                                        else{
                                                                                            echo'<td><span class="badge bg-danger">Deactive</span></td>';
                                                                                        }
                                                                                    echo'</tr>';
                                                                                }
                                                                            }  
                                                                        }
                                                                        //BDM->TE/F/I-TC/IBR->CU
                                                                        $stmt3 = $conn->prepare("SELECT sub_franchisee_id AS suser_id FROM `sub_franchisee` WHERE reference_no = ?
                                                                                                UNION ALL
                                                                                                SELECT institution_id AS suser_id FROM `institution` WHERE reference_no = ? 
                                                                                                UNION ALL
                                                                                                SELECT corporate_agency_id AS suser_id FROM `corporate_agency` WHERE reference_no = ? ");
                                                                        $stmt3->execute([$bdm_id,$bdm_id,$bdm_id]);
                                                                        $userCAs = $stmt3->fetchAll(PDO::FETCH_ASSOC);

                                                                        foreach($userCAs as $userCA){
                                                                            $userCAID = $userCA['suser_id'];
                                                                            // echo $userCA;

                                                                            $stmt4 = $conn->prepare("SELECT ca_travelagency_id AS user_id FROM ca_travelagency WHERE reference_no = ?
                                                                                                    UNION ALL
                                                                                                    SELECT institution_branch_manager_id AS user_id FROM institution_branch_manager WHERE reference_no = ?");
                                                                            $stmt4->execute([$userCA['suser_id'],$userCA['suser_id']]);
                                                                            $userCATAs = $stmt4->fetchAll(PDO::FETCH_ASSOC);

                                                                            foreach ($userCATAs as $userCATA) {
                                                                                $userTA = $userCATA['user_id'];
                                                                            //    echo $userCA.'=>'.$userTA.'</br>';

                                                                                $stmt5 = $conn->prepare("SELECT * FROM ca_customer WHERE ta_reference_no = ? AND (status ='1' OR status = '3') ");
                                                                                $stmt5->execute([$userCATA['ca_travelagency_id']]);
                                                                                $userCACUs = $stmt5->fetchAll(PDO::FETCH_ASSOC);

                                                                                foreach ($userCACUs as $userCACU) {
                                                                                    $userCU = $userCACU['id'];
                                                                                    // echo $userId.'=>'.$userCA.'=>'.$userTA.'=>'.$userCU.'</br>';
                                                                                    $comp_chek = $userCACU['comp_chek'] == '1' ? 'complimentary' : 'Noncomplimentary'; 
                                                                                    $bd= new DateTime($userCACU['date_of_birth']);
                                                                                    $bdate= $bd->format('d-m-Y');
                                                                                    $dt= new DateTime($userCACU['register_date']);
                                                                                    $datev= $dt->format('d-m-Y'); 
                                                                                    echo'<tr>
                                                                                        <td>
                                                                                            <p>'.$userCACU['ca_customer_id'].'</p>
                                                                                            <p>'.$userCACU['firstname'].' '.$userCACU['lastname'].'</p>
                                                                                        </td>
                                                                                        <td>
                                                                                            <p>'.$userCACU['reference_no'].' '.$userCACU['registrant'].'</p>
                                                                                            <p>'.$userCACU['ta_reference_no'].' '.$userCACU['ta_reference_name'].'</p>
                                                                                        </td>
                                                                                        <td>
                                                                                            <p class="mb-0">'.$userCACU['customer_type'].'</p>
                                                                                            <p class="mb-0">'.$comp_chek.'</p>
                                                                                        </td>
                                                                                        <td>'.$userCACU['contact_no'].'</td>
                                                                                        <td>'.$datev.'</td>';
                                                                                        if($userCACU['status'] == '1')
                                                                                            echo'<td><span class="badge bg-success">Active</span></td>';
                                                                                        else{
                                                                                            echo'<td><span class="badge bg-danger">Deactive</span></td>';
                                                                                        }
                                                                                    echo'</tr>';
                                                                                }
                                                                            }   
                                                                        }
                                                                        //BDM->TC->CU
                                                                        $stmt4 = $conn->prepare("SELECT ca_travelagency_id FROM ca_travelagency WHERE reference_no = ?");
                                                                        $stmt4->execute([$bdm_id]);
                                                                        $userCATAs = $stmt4->fetchAll(PDO::FETCH_ASSOC);

                                                                        foreach ($userCATAs as $userCATA) {
                                                                            $userTA = $userCATA['ca_travelagency_id'];

                                                                            $stmt5 = $conn->prepare("SELECT * FROM ca_customer WHERE ta_reference_no = ? AND (status ='1' OR status = '3') ");
                                                                            $stmt5->execute([$userCATA['ca_travelagency_id']]);
                                                                            $userCACUs = $stmt5->fetchAll(PDO::FETCH_ASSOC);

                                                                            foreach ($userCACUs as $userCACU) {
                                                                                $userCU = $userCACU['id'];
                                                                                // echo $userId.'=>'.$userCA.'=>'.$userTA.'=>'.$userCU.'</br>';
                                                                                $comp_chek = $userCACU['comp_chek'] == '1' ? 'complimentary' : 'Noncomplimentary'; 
                                                                                $bd= new DateTime($userCACU['date_of_birth']);
                                                                                $bdate= $bd->format('d-m-Y');
                                                                                $dt= new DateTime($userCACU['register_date']);
                                                                                $datev= $dt->format('d-m-Y'); 
                                                                                echo'<tr>
                                                                                    <td>
                                                                                        <p>'.$userCACU['ca_customer_id'].'</p>
                                                                                        <p>'.$userCACU['firstname'].' '.$userCACU['lastname'].'</p>
                                                                                    </td>
                                                                                    <td>
                                                                                        <p>'.$userCACU['reference_no'].' '.$userCACU['registrant'].'</p>
                                                                                        <p>'.$userCACU['ta_reference_no'].' '.$userCACU['ta_reference_name'].'</p>
                                                                                    </td>
                                                                                    <td>
                                                                                        <p class="mb-0">'.$userCACU['customer_type'].'</p>
                                                                                        <p class="mb-0">'.$comp_chek.'</p>
                                                                                    </td>
                                                                                    <td>'.$userCACU['contact_no'].'</td>
                                                                                    <td>'.$datev.'</td>';
                                                                                    if($userCACU['status'] == '1')
                                                                                        echo'<td><span class="badge bg-success">Active</span></td>';
                                                                                    else{
                                                                                        echo'<td><span class="badge bg-danger">Deactive</span></td>';
                                                                                    }
                                                                                echo'</tr>';
                                                                            }
                                                                        }  
                                                                    }
                                                                }else if($userType == "25"){
                                                                    
                                                                    //BM/MF/SF->TE/F/I->TC/IBR->CU
                                                                    $stmt2 = $conn->prepare("SELECT business_mentor_id AS id FROM business_mentor WHERE reference_no = ? AND user_type = '26' 
                                                                                            UNION ALL
                                                                                            SELECT master_franchisee_id AS id FROM master_franchisee WHERE reference_no = ? AND user_type = '28'
                                                                                            UNION ALL
                                                                                            SELECT sponsor_franchisee_id AS id FROM sponsor_franchisee WHERE reference_no = ? AND user_type = '30'");
                                                                    $stmt2->execute([$userId,$userId,$userId]);
                                                                    $userBMS = $stmt2->fetchAll(PDO::FETCH_ASSOC);
                                                                
                                                                    foreach ($userBMS as $userBM) {
                                                                        $bm_id = $userBM['id'];

                                                                        $stmt3 = $conn->prepare("SELECT corporate_agency_id AS suser_id FROM `corporate_agency` WHERE reference_no = ? 
                                                                                                UNION ALL
                                                                                                SELECT sub_franchisee_id AS suser_id FROM `sub_franchisee` WHERE reference_no = ?
                                                                                                UNION ALL
                                                                                                SELECT institution_id AS suser_id FROM `institution` WHERE reference_no = ?");
                                                                        $stmt3->execute([$bm_id,$bm_id,$bm_id]);
                                                                        $userCAs = $stmt3->fetchAll(PDO::FETCH_ASSOC);

                                                                        foreach($userCAs as $userCA){
                                                                            $userCAID = $userCA['suser_id'];
                                                                            // echo $userCA;

                                                                            $stmt4 = $conn->prepare("SELECT ca_travelagency_id AS user_id FROM ca_travelagency WHERE reference_no = ?
                                                                                                    uNION ALL
                                                                                                    SELECT institution_branch_manager_id AS user_id FROM institution_branch_manager WHERE reference_no = ?");
                                                                            $stmt4->execute([$userCA['suser_id'],$userCA['suser_id']]);
                                                                            $userCATAs = $stmt4->fetchAll(PDO::FETCH_ASSOC);

                                                                            foreach ($userCATAs as $userCATA) {
                                                                                $userTA = $userCATA['user_id'];
                                                                                //    echo $userCA.'=>'.$userTA.'</br>';

                                                                                $stmt5 = $conn->prepare("SELECT * FROM ca_customer WHERE ta_reference_no = ? AND (status ='1' OR status = '3') ");
                                                                                $stmt5->execute([$userCATA['user_id']]);
                                                                                $userCACUs = $stmt5->fetchAll(PDO::FETCH_ASSOC);

                                                                                foreach ($userCACUs as $userCACU) {
                                                                                    $userCU = $userCACU['id'];
                                                                                    // echo $userId.'=>'.$userCA.'=>'.$userTA.'=>'.$userCU.'</br>';
                                                                                    $comp_chek = $userCACU['comp_chek'] == '1' ? 'complimentary' : 'Noncomplimentary'; 
                                                                                    $bd= new DateTime($userCACU['date_of_birth']);
                                                                                    $bdate= $bd->format('d-m-Y');
                                                                                    $dt= new DateTime($userCACU['register_date']);
                                                                                    $datev= $dt->format('d-m-Y'); 
                                                                                    echo'<tr>
                                                                                        <td>
                                                                                            <p>'.$userCACU['ca_customer_id'].'</p>
                                                                                            <p>'.$userCACU['firstname'].' '.$userCACU['lastname'].'</p>
                                                                                        </td>
                                                                                        <td>
                                                                                            <p>'.$userCACU['reference_no'].' '.$userCACU['registrant'].'</p>
                                                                                            <p>'.$userCACU['ta_reference_no'].' '.$userCACU['ta_reference_name'].'</p>
                                                                                        </td>
                                                                                        <td>
                                                                                            <p class="mb-0">'.$userCACU['customer_type'].'</p>
                                                                                            <p class="mb-0">'.$comp_chek.'</p>
                                                                                        </td>
                                                                                        <td>'.$userCACU['contact_no'].'</td>
                                                                                        <td>'.$datev.'</td>';
                                                                                        if($userCACU['status'] == '1')
                                                                                            echo'<td><span class="badge bg-success">Active</span></td>';
                                                                                        else{
                                                                                            echo'<td><span class="badge bg-danger">Deactive</span></td>';
                                                                                        }
                                                                                    echo'</tr>';
                                                                                }
                                                                            }   
                                                                        }
                                                                        
                                                                        //direct TC with BM/MF Ref
                                                                        $stmt4 = $conn->prepare("SELECT ca_travelagency_id FROM ca_travelagency WHERE reference_no = ?");
                                                                        $stmt4->execute([$bm_id]);
                                                                        $userCATAs = $stmt4->fetchAll(PDO::FETCH_ASSOC);

                                                                        foreach ($userCATAs as $userCATA) {
                                                                            $userTA = $userCATA['ca_travelagency_id'];

                                                                            $stmt5 = $conn->prepare("SELECT * FROM ca_customer WHERE ta_reference_no = ? AND (status ='1' OR status = '3') ");
                                                                            $stmt5->execute([$userCATA['ca_travelagency_id']]);
                                                                            $userCACUs = $stmt5->fetchAll(PDO::FETCH_ASSOC);

                                                                            foreach ($userCACUs as $userCACU) {
                                                                                $userCU = $userCACU['id'];
                                                                                // echo $userId.'=>'.$userCA.'=>'.$userTA.'=>'.$userCU.'</br>';
                                                                                $comp_chek = $userCACU['comp_chek'] == '1' ? 'complimentary' : 'Noncomplimentary'; 
                                                                                $bd= new DateTime($userCACU['date_of_birth']);
                                                                                $bdate= $bd->format('d-m-Y');
                                                                                $dt= new DateTime($userCACU['register_date']);
                                                                                $datev= $dt->format('d-m-Y'); 
                                                                                echo'<tr>
                                                                                    <td>
                                                                                        <p>'.$userCACU['ca_customer_id'].'</p>
                                                                                        <p>'.$userCACU['firstname'].' '.$userCACU['lastname'].'</p>
                                                                                    </td>
                                                                                    <td>
                                                                                        <p>'.$userCACU['reference_no'].' '.$userCACU['registrant'].'</p>
                                                                                        <p>'.$userCACU['ta_reference_no'].' '.$userCACU['ta_reference_name'].'</p>
                                                                                    </td>
                                                                                    <td>
                                                                                        <p class="mb-0">'.$userCACU['customer_type'].'</p>
                                                                                        <p class="mb-0">'.$comp_chek.'</p>
                                                                                    </td>
                                                                                    <td>'.$userCACU['contact_no'].'</td>
                                                                                    <td>'.$datev.'</td>';
                                                                                    if($userCACU['status'] == '1')
                                                                                        echo'<td><span class="badge bg-success">Active</span></td>';
                                                                                    else{
                                                                                        echo'<td><span class="badge bg-danger">Deactive</span></td>';
                                                                                    }
                                                                                echo'</tr>';
                                                                            }
                                                                        }  
                                                                    }
                                                                    
                                                                    //BDM->F/TE/TE-TC/IBR->CU
                                                                    $stmt3 = $conn->prepare("SELECT sub_franchisee_id AS suser_id FROM `sub_franchisee` WHERE reference_no = ? 
                                                                                            UNION ALL
                                                                                            SELECT corporate_agency_id AS suser_id FROM `corporate_agency` WHERE reference_no = ?
                                                                                            UNION ALL
                                                                                            SELECT institution_id AS suser_id FROM `institution` WHERE reference_no = ?");
                                                                    $stmt3->execute([$userId,$userId,$userId]);
                                                                    $userCAs = $stmt3->fetchAll(PDO::FETCH_ASSOC);

                                                                    foreach($userCAs as $userCA){
                                                                        $userCAID = $userCA['suser_id'];
                                                                        // echo $userCA;

                                                                        $stmt4 = $conn->prepare("SELECT ca_travelagency_id AS user_id FROM ca_travelagency WHERE reference_no = ?
                                                                                                UNION ALL
                                                                                                SELECT institution_branch_manager_id AS user_id FROM institution_branch_manager WHERE reference_no = ?");
                                                                        $stmt4->execute([$userCA['suser_id'],$userCA['suser_id']]);
                                                                        $userCATAs = $stmt4->fetchAll(PDO::FETCH_ASSOC);

                                                                        foreach ($userCATAs as $userCATA) {
                                                                            $userTA = $userCATA['user_id'];
                                                                            //    echo $userCA.'=>'.$userTA.'</br>';

                                                                            $stmt5 = $conn->prepare("SELECT * FROM ca_customer WHERE ta_reference_no = ? AND (status ='1' OR status = '3') ");
                                                                            $stmt5->execute([$userCATA['user_id']]);
                                                                            $userCACUs = $stmt5->fetchAll(PDO::FETCH_ASSOC);

                                                                            foreach ($userCACUs as $userCACU) {
                                                                                $userCU = $userCACU['id'];
                                                                                // echo $userId.'=>'.$userCA.'=>'.$userTA.'=>'.$userCU.'</br>';
                                                                                $comp_chek = $userCACU['comp_chek'] == '1' ? 'complimentary' : 'Noncomplimentary'; 
                                                                                $bd= new DateTime($userCACU['date_of_birth']);
                                                                                $bdate= $bd->format('d-m-Y');
                                                                                $dt= new DateTime($userCACU['register_date']);
                                                                                $datev= $dt->format('d-m-Y'); 
                                                                                echo'<tr>
                                                                                    <td>
                                                                                        <p>'.$userCACU['ca_customer_id'].'</p>
                                                                                        <p>'.$userCACU['firstname'].' '.$userCACU['lastname'].'</p>
                                                                                    </td>
                                                                                    <td>
                                                                                        <p>'.$userCACU['reference_no'].' '.$userCACU['registrant'].'</p>
                                                                                        <p>'.$userCACU['ta_reference_no'].' '.$userCACU['ta_reference_name'].'</p>
                                                                                    </td>
                                                                                    <td>
                                                                                        <p class="mb-0">'.$userCACU['customer_type'].'</p>
                                                                                        <p class="mb-0">'.$comp_chek.'</p>
                                                                                    </td>
                                                                                    <td>'.$userCACU['contact_no'].'</td>
                                                                                    <td>'.$datev.'</td>';
                                                                                    if($userCACU['status'] == '1')
                                                                                        echo'<td><span class="badge bg-success">Active</span></td>';
                                                                                    else{
                                                                                        echo'<td><span class="badge bg-danger">Deactive</span></td>';
                                                                                    }
                                                                                echo'</tr>';
                                                                            }
                                                                        }   
                                                                    }
                                                                    //BDM->TC->CU
                                                                    $stmt4 = $conn->prepare("SELECT ca_travelagency_id FROM ca_travelagency WHERE reference_no = ?");
                                                                    $stmt4->execute([$userId]);
                                                                    $userCATAs = $stmt4->fetchAll(PDO::FETCH_ASSOC);

                                                                    foreach ($userCATAs as $userCATA) {
                                                                        $userTA = $userCATA['ca_travelagency_id'];

                                                                        $stmt5 = $conn->prepare("SELECT * FROM ca_customer WHERE ta_reference_no = ? AND (status ='1' OR status = '3') ");
                                                                        $stmt5->execute([$userCATA['ca_travelagency_id']]);
                                                                        $userCACUs = $stmt5->fetchAll(PDO::FETCH_ASSOC);

                                                                        foreach ($userCACUs as $userCACU) {
                                                                            $userCU = $userCACU['id'];
                                                                            // echo $userId.'=>'.$userCA.'=>'.$userTA.'=>'.$userCU.'</br>';
                                                                            $comp_chek = $userCACU['comp_chek'] == '1' ? 'complimentary' : 'Noncomplimentary'; 
                                                                            $bd= new DateTime($userCACU['date_of_birth']);
                                                                            $bdate= $bd->format('d-m-Y');
                                                                            $dt= new DateTime($userCACU['register_date']);
                                                                            $datev= $dt->format('d-m-Y'); 
                                                                            echo'<tr>
                                                                                <td>
                                                                                    <p>'.$userCACU['ca_customer_id'].'</p>
                                                                                    <p>'.$userCACU['firstname'].' '.$userCACU['lastname'].'</p>
                                                                                </td>
                                                                                <td>
                                                                                    <p>'.$userCACU['reference_no'].' '.$userCACU['registrant'].'</p>
                                                                                    <p>'.$userCACU['ta_reference_no'].' '.$userCACU['ta_reference_name'].'</p>
                                                                                </td>
                                                                                <td>
                                                                                    <p class="mb-0">'.$userCACU['customer_type'].'</p>
                                                                                    <p class="mb-0">'.$comp_chek.'</p>
                                                                                </td>
                                                                                <td>'.$userCACU['contact_no'].'</td>
                                                                                <td>'.$datev.'</td>';
                                                                                if($userCACU['status'] == '1')
                                                                                    echo'<td><span class="badge bg-success">Active</span></td>';
                                                                                else{
                                                                                    echo'<td><span class="badge bg-danger">Deactive</span></td>';
                                                                                }
                                                                            echo'</tr>';
                                                                        }
                                                                    }   
                                                                    
                                                                }else if( $userType == "26" || $userType =="28" || $userType =="30"){
                                                                    $stmt2 = $conn->prepare("SELECT sub_franchisee_id AS suser_id FROM `sub_franchisee` WHERE reference_no = ?
                                                                                            UNION ALL
                                                                                            SELECT corporate_agency_id AS suser_id FROM `corporate_agency` WHERE reference_no = ?
                                                                                            UNION ALL
                                                                                            SELECT institution_id AS suser_id FROM `institution` WHERE reference_no = ? ");
                                                                    
                                                                    $stmt2->execute([$userId,$userId,$userId]);
                                                                    $referrals = $stmt2->fetchAll(PDO::FETCH_ASSOC);

                                                                    foreach($referrals as $referral){
                                                                        $userCA = $referral['suser_id'];
                                                                        // echo $userCA;

                                                                        $stmt4 = $conn->prepare("SELECT ca_travelagency_id AS user_id FROM ca_travelagency WHERE reference_no = ? 
                                                                                                UNION ALL
                                                                                                SELECT institution_branch_manager_id AS user_id FROM institution_branch_manager WHERE reference_no = ?");
                                                                        $stmt4->execute([$userCA,$userCA]);
                                                                        $userCATAs = $stmt4->fetchAll(PDO::FETCH_ASSOC);

                                                                        foreach ($userCATAs as $userCATA) {
                                                                            $userTA = $userCATA['user_id'];
                                                                            //echo $userCA.'=>'.$userTA.'</br>';

                                                                            $stmt5 = $conn->prepare("SELECT * FROM ca_customer WHERE ta_reference_no = ? AND (status ='1' OR status = '3') ");
                                                                            $stmt5->execute([$userCATA['user_id']]);
                                                                            $userCACUs = $stmt5->fetchAll(PDO::FETCH_ASSOC);

                                                                            foreach ($userCACUs as $userCACU) {
                                                                                $comp_chek = $userCACU['comp_chek'] == '1' ? 'complimentary' : 'Noncomplimentary'; 
                                                                                $userCU = $userCACU['ca_customer_id'];
                                                                                // echo $userId.'=>'.$userCA.'=>'.$userTA.'=>'.$userCU.'</br>';

                                                                                $bd= new DateTime($userCACU['date_of_birth']);
                                                                                $bdate= $bd->format('d-m-Y');
                                                                                $dt= new DateTime($userCACU['register_date']);
                                                                                $datev= $dt->format('d-m-Y'); 
                                                                                echo'<tr>
                                                                                    <td>
                                                                                        <p>'.$userCACU['ca_customer_id'].'</p>
                                                                                        <p>'.$userCACU['firstname'].' '.$userCACU['lastname'].'</p>
                                                                                    </td>
                                                                                    <td>
                                                                                        <p>'.$userCACU['reference_no'].' '.$userCACU['registrant'].'</p>
                                                                                        <p>'.$userCACU['ta_reference_no'].' '.$userCACU['ta_reference_name'].'</p>
                                                                                    </td>
                                                                                    <td>
                                                                                        <p class="mb-0">'.$userCACU['customer_type'].'</p>
                                                                                        <p class="mb-0">'.$comp_chek.'</p>
                                                                                    </td>
                                                                                    <td>'.$userCACU['contact_no'].'</td>
                                                                                    <td>'.$datev.'</td>';
                                                                                    if($userCACU['status'] == '1'){
                                                                                        echo'<td><span class="badge bg-success">Active</span></td>';
                                                                                        
                                                                                    }else{
                                                                                        echo'<td><span class="badge bg-danger">Deactivate</span></td>';
                                                                                        
                                                                                    }
                                                                                echo'</tr>';
                                                                            }
                                                                        }   
                                                                    }
                                                                    
                                                                    //direct TC with BM/MF Ref
                                                                    $stmt4 = $conn->prepare("SELECT ca_travelagency_id FROM ca_travelagency WHERE reference_no = ? ");
                                                                    $stmt4->execute([$userId]);
                                                                    $userCATAs = $stmt4->fetchAll(PDO::FETCH_ASSOC);

                                                                    foreach ($userCATAs as $userCATA) {
                                                                        $userTA = $userCATA['ca_travelagency_id'];
                                                                        //echo $userCA.'=>'.$userTA.'</br>';

                                                                        $stmt5 = $conn->prepare("SELECT * FROM ca_customer WHERE ta_reference_no = ? AND (status ='1' OR status = '3') ");
                                                                        $stmt5->execute([$userCATA['ca_travelagency_id']]);
                                                                        $userCACUs = $stmt5->fetchAll(PDO::FETCH_ASSOC);

                                                                        foreach ($userCACUs as $userCACU) {
                                                                            $comp_chek = $userCACU['comp_chek'] == '1' ? 'complimentary' : 'Noncomplimentary'; 
                                                                            $userCU = $userCACU['ca_customer_id'];
                                                                            // echo $userId.'=>'.$userCA.'=>'.$userTA.'=>'.$userCU.'</br>';

                                                                            $bd= new DateTime($userCACU['date_of_birth']);
                                                                            $bdate= $bd->format('d-m-Y');
                                                                            $dt= new DateTime($userCACU['register_date']);
                                                                            $datev= $dt->format('d-m-Y'); 
                                                                            echo'<tr>
                                                                                <td>
                                                                                    <p>'.$userCACU['ca_customer_id'].'</p>
                                                                                    <p>'.$userCACU['firstname'].' '.$userCACU['lastname'].'</p>
                                                                                </td>
                                                                                <td>
                                                                                    <p>'.$userCACU['reference_no'].' '.$userCACU['registrant'].'</p>
                                                                                    <p>'.$userCACU['ta_reference_no'].' '.$userCACU['ta_reference_name'].'</p>
                                                                                </td>
                                                                                <td>
                                                                                    <p class="mb-0">'.$userCACU['customer_type'].'</p>
                                                                                    <p class="mb-0">'.$comp_chek.'</p>
                                                                                </td>
                                                                                <td>'.$userCACU['contact_no'].'</td>
                                                                                <td>'.$datev.'</td>';
                                                                                if($userCACU['status'] == '1'){
                                                                                    echo'<td><span class="badge bg-success">Active</span></td>';
                                                                                    
                                                                                }else{
                                                                                    echo'<td><span class="badge bg-danger">Deactivate</span></td>';
                                                                                    
                                                                                }
                                                                            echo'</tr>';
                                                                        }
                                                                    }  
                                                                }else if($userType == "16" || $userType == "29" || $userType == '32'){
                                                                    
                                                                    $stmt4 = $conn->prepare("SELECT ca_travelagency_id AS user_id FROM ca_travelagency WHERE reference_no = ?
                                                                                            UNION ALL
                                                                                            SELECT institution_branch_manager_id AS user_id FROM institution_branch_manager WHERE reference_no = ?");
                                                                    $stmt4->execute([$userId,$userId]);
                                                                    $userCATAs = $stmt4->fetchAll(PDO::FETCH_ASSOC);

                                                                    foreach ($userCATAs as $userCATA) {
                                                                        $userTA = $userCATA['user_id'];
                                                                        // echo $userTA.'</br>';

                                                                        $stmt5 = $conn->prepare("SELECT * FROM ca_customer WHERE ta_reference_no = ? AND (status='1' OR status = '3')");
                                                                        $stmt5->execute([$userCATA['user_id']]);
                                                                        $userCACUs = $stmt5->fetchAll(PDO::FETCH_ASSOC);

                                                                        foreach ($userCACUs as $userCACU) {
                                                                            $userCU = $userCACU['id'];
                                                                            $comp_chek = $userCACU['comp_chek'] == '1' ? 'complimentary' : 'Noncomplimentary'; 
                                                                            // echo $userTA.'=>'.$userCU.'</br>';

                                                                            $bd= new DateTime($userCACU['date_of_birth']);
                                                                            $bdate= $bd->format('d-m-Y');
                                                                            $dt= new DateTime($userCACU['register_date']);
                                                                            $datev= $dt->format('d-m-Y'); 
                                                                            echo'<tr>
                                                                                <td>
                                                                                    <p>'.$userCACU['ca_customer_id'].'</p>
                                                                                    <p>'.$userCACU['firstname'].' '.$userCACU['lastname'].'</p>
                                                                                </td>
                                                                                <td>
                                                                                    <p>'.$userCACU['reference_no'].' '.$userCACU['registrant'].'</p>
                                                                                    <p>'.$userCACU['ta_reference_no'].' '.$userCACU['ta_reference_name'].'</p>
                                                                                </td>
                                                                                    <td>
                                                                                    <p class="mb-0">'.$userCACU['customer_type'].'</p>
                                                                                    <p class="mb-0">'.$comp_chek.'</p>
                                                                                </td>
                                                                                <td>'.$userCACU['contact_no'].'</td>
                                                                                <td>'.$datev.'</td>';
                                                                                if($userCACU['status'] == '3')
                                                                                    echo'<td><span class="badge bg-danger">Pending</span></td>';
                                                                                else{
                                                                                    echo'<td><span class="badge bg-success">Active</span></td>';
                                                                                }
                                                                            echo'</tr>';
                                                                        }
                                                                    }
                                                                }else if($userType == "11" || $userType == "33"){
                                                                    $sql = "SELECT * FROM `ca_customer` WHERE ta_reference_no = '$userId' AND (status = '1' OR status = '3') ";
                                                                    $stmt = $conn -> prepare($sql);
                                                                    $stmt -> execute();
                                                                    $stmt -> setFetchMode(PDO::FETCH_ASSOC);
                                                                    if($stmt -> rowCount()>0){
                                                                        foreach(($stmt -> fetchAll()) as $key => $row){
                                                                            $bd= new DateTime($row['date_of_birth']);
                                                                            $bdate= $bd->format('d-m-Y');
                                                                            $dt= new DateTime($row['register_date']);
                                                                            $datev= $dt->format('d-m-Y'); 
                                                                            $comp_chek = $row['comp_chek'] == '1' ? 'complimentary' : 'Noncomplimentary'; 
                                                                            echo'<tr>
                                                                                <td>
                                                                                    <p>'.$row['ca_customer_id'].'</p>
                                                                                    <p>'.$row['firstname'].' '.$row['lastname'].'</p>
                                                                                </td>
                                                                                <td>
                                                                                    <p>'.$row['ta_reference_no'].' '.$row['ta_reference_name'].'</p>
                                                                                    <p>'.$row['reference_no'].' '.$row['registrant'].'</p>
                                                                                </td>
                                                                                <td>
                                                                                    <p class="mb-0">'.$row['customer_type'].'</p>
                                                                                    <p class="mb-0">'.$comp_chek.'</p>
                                                                                </td>
                                                                                <td>'.$row['contact_no'].'</td>
                                                                                <td>'.$datev.'</td>';
                                                                                
                                                                                if($row['status'] == '3')
                                                                                    echo'<td><span class="badge bg-danger">Deleted</span></td>';
                                                                                else{
                                                                                    echo'<td><span class="badge bg-success">Active</span></td>';
                                                                                }
                                                                                if($userType == '11' || $userType == '33'){
                                                                                    if($row['status'] == '1'){
                                                                                        echo'<td>
                                                                                            <div class="dropdown d-inline-block">
                                                                                                <button class="btn btn-soft-secondary btn-sm dropdown" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                                                                    <i class="ri-more-fill align-middle"></i>
                                                                                                </button>
                                                                                                <ul class="dropdown-menu dropdown-menu-end">
                                                                                                    <li><a class="dropdown-item edit-item-btn" onclick=\'overviewPage("'.$row["ca_customer_id"]. '","' .$row["reference_no"]. '","' .$row["country"]. '","' .$row["state"]. '","' .$row["city"]. '","ca_customer")\'><i class="ri-eye-fill align-bottom me-2 text-muted"></i> Overview</a></li>
                                                                                                    <li><a class="dropdown-item addref-item-btn" onclick=\'addRefFunc("' .$row["ca_customer_id"]. '","'.$userId.'","' .$row["country"]. '","' .$row["state"]. '","' .$row["city"]. '","addreff")\'><i class="ri-contacts-fill align-bottom me-2 text-muted"></i> Add Ref</a></li>
                                                                                                    <li><a class="dropdown-item edit-item-btn" onclick=\'editfunc("' .$row["ca_customer_id"]. '","' .$row["country"]. '","' .$row["state"]. '","' .$row["city"]. '","registered")\'><i class="ri-pencil-fill align-bottom me-2 text-muted"></i> Edit</a></li>
                                                                                                    <li><a class="dropdown-item remove-item-btn" onclick=\'deletefunc("'.$row["id"].'","'.$row["ca_customer_id"].'","registered","'.$userId.'","'.$userType.'")\'><i class="ri-delete-bin-fill align-bottom me-2 text-muted"></i> Delete</a></li>
                                                                                                </ul>
                                                                                            </div>
                                                                                        </td>';
                                                                                    }else{
                                                                                        echo'<td>
                                                                                        <div class="dropdown d-inline-block">
                                                                                            <button class="btn btn-soft-secondary btn-sm dropdown" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                                                                <i class="ri-more-fill align-middle"></i>
                                                                                            </button>
                                                                                            <ul class="dropdown-menu dropdown-menu-end">
                                                                                                <li><a class="dropdown-item remove-item-btn" onclick=\'deletefunc("'.$row["id"].'","'.$row["ca_customer_id"].'","deactivate","'.$userId.'","'.$userType.'")\'><i class="ri-arrow-go-back-fill align-bottom me-2 text-muted"></i> Restore</a></li>
                                                                                            </ul>
                                                                                        </div>
                                                                                    </td>';
                                                                                    }
                                                                                }
                                                                            echo'</tr>';
                                                                        }
                                                                    }
                                                                }else if($userType == "10"){
                                                                    $sql = "SELECT * FROM `ca_customer` WHERE reference_no = '$userId' AND (status = '1' OR status = '3') ";
                                                                    $stmt = $conn -> prepare($sql);
                                                                    $stmt -> execute();
                                                                    $stmt -> setFetchMode(PDO::FETCH_ASSOC);
                                                                    if($stmt -> rowCount()>0){
                                                                        foreach(($stmt -> fetchAll()) as $key => $row){
                                                                            $bd= new DateTime($row['date_of_birth']);
                                                                            $bdate= $bd->format('d-m-Y');
                                                                            $dt= new DateTime($row['register_date']);
                                                                            $datev= $dt->format('d-m-Y'); 
                                                                            $comp_chek = $row['comp_chek'] == '1' ? 'complimentary' : 'Noncomplimentary'; 
                                                                            echo'<tr>
                                                                                <td>
                                                                                    <p>'.$row['ca_customer_id'].'</p>
                                                                                    <p>'.$row['firstname'].' '.$row['lastname'].'</p>
                                                                                </td>
                                                                                <td>
                                                                                    <p>'.$row['ta_reference_no'].' '.$row['ta_reference_name'].'</p>
                                                                                    <p>'.$row['reference_no'].' '.$row['registrant'].'</p>
                                                                                </td>
                                                                                <td>
                                                                                    <p class="mb-0">'.$row['customer_type'].'</p>
                                                                                    <p class="mb-0">'.$comp_chek.'</p>
                                                                                </td>
                                                                                <td>'.$row['contact_no'].'</td>
                                                                                <td>'.$datev.'</td>';
                                                                                
                                                                                if($row['status'] == '3')
                                                                                    echo'<td><span class="badge bg-danger">Deleted</span></td>';
                                                                                else{
                                                                                    echo'<td><span class="badge bg-success">Active</span></td>';
                                                                                }
                                                                                if($userType == '10'){
                                                                                    if($row['status'] == '1'){
                                                                                        echo'<td>
                                                                                            <div class="dropdown d-inline-block">
                                                                                                <button class="btn btn-soft-secondary btn-sm dropdown" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                                                                    <i class="ri-more-fill align-middle"></i>
                                                                                                </button>
                                                                                                <ul class="dropdown-menu dropdown-menu-end">
                                                                                                    <li><a class="dropdown-item edit-item-btn" onclick=\'editfunc("' .$row["ca_customer_id"]. '","' .$row["country"]. '","' .$row["state"]. '","' .$row["city"]. '","registered")\'><i class="ri-pencil-fill align-bottom me-2 text-muted"></i> Edit</a></li>
                                                                                                    <li><a class="dropdown-item remove-item-btn" onclick=\'deletefunc("'.$row["id"].'","'.$row["ca_customer_id"].'","'.$row["reference_no"].'","registered","'.$userId.'","'.$userType.'")\'><i class="ri-delete-bin-fill align-bottom me-2 text-muted"></i> Delete</a></li>
                                                                                                </ul>
                                                                                            </div>
                                                                                        </td>';
                                                                                    }else{
                                                                                        echo'<td>
                                                                                        <div class="dropdown d-inline-block">
                                                                                            <button class="btn btn-soft-secondary btn-sm dropdown" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                                                                <i class="ri-more-fill align-middle"></i>
                                                                                            </button>
                                                                                            <ul class="dropdown-menu dropdown-menu-end">
                                                                                                <li><a class="dropdown-item remove-item-btn" onclick=\'deletefunc("'.$row["id"].'","'.$row["ca_customer_id"].'","'.$row["reference_no"].'","deactivate","'.$userId.'","'.$userType.'")\'><i class="ri-arrow-go-back-fill align-bottom me-2 text-muted"></i> Restore</a></li>
                                                                                            </ul>
                                                                                        </div>
                                                                                    </td>';
                                                                                    }
                                                                                }
                                                                            echo'</tr>';
                                                                        }
                                                                    }
                                                                }else if($userType == "31"){
                                                                    
                                                                    //MF/SF->F->TC->CU
                                                                    $stmt2 = $conn->prepare("SELECT master_franchisee_id AS id FROM master_franchisee WHERE reference_no = ? AND user_type = '28'
                                                                                                UNION
                                                                                                SELECT sponsor_franchisee_id AS id FROM sponsor_franchisee WHERE reference_no = ? AND user_type = '30' ");
                                                                    $stmt2->execute([$userId,$userId]);
                                                                    $userBMS = $stmt2->fetchAll(PDO::FETCH_ASSOC);
                                                                
                                                                    foreach ($userBMS as $userBM) {
                                                                        $bm_id = $userBM['id'];

                                                                        $stmt3 = $conn->prepare("SELECT sub_franchisee_id AS suser_id FROM `sub_franchisee` WHERE reference_no = ?
                                                                                                UNION ALL
                                                                                                SELECT corporate_agency_id AS suser_id FROM `corporate_agency` WHERE reference_no = ?
                                                                                                UNION ALL
                                                                                                SELECT institution_id AS suser_id FROM `institution` WHERE reference_no = ? ");
                                                                        $stmt3->execute([$bm_id,$bm_id,$bm_id]);
                                                                        $userCAs = $stmt3->fetchAll(PDO::FETCH_ASSOC);

                                                                        foreach($userCAs as $userCA){
                                                                            $userCAID = $userCA['suser_id'];
                                                                            // echo $userCA;

                                                                            $stmt4 = $conn->prepare("SELECT ca_travelagency_id AS user_id FROM ca_travelagency WHERE reference_no = ?
                                                                                                    UNION ALL
                                                                                                    SELECT institution_branch_manager_id AS user_id FROM institution_branch_manager WHERE reference_no = ?");
                                                                            $stmt4->execute([$userCA['suser_id'],$userCA['suser_id']]);
                                                                            $userCATAs = $stmt4->fetchAll(PDO::FETCH_ASSOC);

                                                                            foreach ($userCATAs as $userCATA) {
                                                                                $userTA = $userCATA['user_id'];
                                                                            //    echo $userCA.'=>'.$userTA.'</br>';

                                                                                $stmt5 = $conn->prepare("SELECT * FROM ca_customer WHERE ta_reference_no = ? AND (status ='1' OR status = '3') ");
                                                                                $stmt5->execute([$userCATA['user_id']]);
                                                                                $userCACUs = $stmt5->fetchAll(PDO::FETCH_ASSOC);

                                                                                foreach ($userCACUs as $userCACU) {
                                                                                    $userCU = $userCACU['id'];
                                                                                    // echo $userId.'=>'.$userCA.'=>'.$userTA.'=>'.$userCU.'</br>';
                                                                                    $comp_chek = $userCACU['comp_chek'] == '1' ? 'complimentary' : 'Noncomplimentary'; 
                                                                                    $bd= new DateTime($userCACU['date_of_birth']);
                                                                                    $bdate= $bd->format('d-m-Y');
                                                                                    $dt= new DateTime($userCACU['register_date']);
                                                                                    $datev= $dt->format('d-m-Y'); 
                                                                                    echo'<tr>
                                                                                        <td>
                                                                                            <p>'.$userCACU['ca_customer_id'].'</p>
                                                                                            <p>'.$userCACU['firstname'].' '.$userCACU['lastname'].'</p>
                                                                                        </td>
                                                                                        <td>
                                                                                            <p>'.$userCACU['reference_no'].' '.$userCACU['registrant'].'</p>
                                                                                            <p>'.$userCACU['ta_reference_no'].' '.$userCACU['ta_reference_name'].'</p>
                                                                                        </td>
                                                                                        <td>
                                                                                            <p class="mb-0">'.$userCACU['customer_type'].'</p>
                                                                                            <p class="mb-0">'.$comp_chek.'</p>
                                                                                        </td>
                                                                                        <td>'.$userCACU['contact_no'].'</td>
                                                                                        <td>'.$datev.'</td>';
                                                                                        if($userCACU['status'] == '1')
                                                                                            echo'<td><span class="badge bg-success">Active</span></td>';
                                                                                        else{
                                                                                            echo'<td><span class="badge bg-danger">Deactive</span></td>';
                                                                                        }
                                                                                    echo'</tr>';
                                                                                }
                                                                            }   
                                                                        }
                                                                        
                                                                        //direct TC with MF/SF Ref
                                                                        $stmt4 = $conn->prepare("SELECT ca_travelagency_id FROM ca_travelagency WHERE reference_no = ?");
                                                                        $stmt4->execute([$bm_id]);
                                                                        $userCATAs = $stmt4->fetchAll(PDO::FETCH_ASSOC);

                                                                        foreach ($userCATAs as $userCATA) {
                                                                            $userTA = $userCATA['ca_travelagency_id'];

                                                                            $stmt5 = $conn->prepare("SELECT * FROM ca_customer WHERE ta_reference_no = ? AND (status ='1' OR status = '3') ");
                                                                            $stmt5->execute([$userCATA['ca_travelagency_id']]);
                                                                            $userCACUs = $stmt5->fetchAll(PDO::FETCH_ASSOC);

                                                                            foreach ($userCACUs as $userCACU) {
                                                                                $userCU = $userCACU['id'];
                                                                                // echo $userId.'=>'.$userCA.'=>'.$userTA.'=>'.$userCU.'</br>';
                                                                                $comp_chek = $userCACU['comp_chek'] == '1' ? 'complimentary' : 'Noncomplimentary'; 
                                                                                $bd= new DateTime($userCACU['date_of_birth']);
                                                                                $bdate= $bd->format('d-m-Y');
                                                                                $dt= new DateTime($userCACU['register_date']);
                                                                                $datev= $dt->format('d-m-Y'); 
                                                                                echo'<tr>
                                                                                    <td>
                                                                                        <p>'.$userCACU['ca_customer_id'].'</p>
                                                                                        <p>'.$userCACU['firstname'].' '.$userCACU['lastname'].'</p>
                                                                                    </td>
                                                                                    <td>
                                                                                        <p>'.$userCACU['reference_no'].' '.$userCACU['registrant'].'</p>
                                                                                        <p>'.$userCACU['ta_reference_no'].' '.$userCACU['ta_reference_name'].'</p>
                                                                                    </td>
                                                                                    <td>
                                                                                        <p class="mb-0">'.$userCACU['customer_type'].'</p>
                                                                                        <p class="mb-0">'.$comp_chek.'</p>
                                                                                    </td>
                                                                                    <td>'.$userCACU['contact_no'].'</td>
                                                                                    <td>'.$datev.'</td>';
                                                                                    if($userCACU['status'] == '1')
                                                                                        echo'<td><span class="badge bg-success">Active</span></td>';
                                                                                    else{
                                                                                        echo'<td><span class="badge bg-danger">Deactive</span></td>';
                                                                                    }
                                                                                echo'</tr>';
                                                                            }
                                                                        }  
                                                                    }
                                                                    //BDM->F-TC->CU
                                                                    $stmt3 = $conn->prepare("SELECT sub_franchisee_id AS suser_id FROM `sub_franchisee` WHERE reference_no = ?
                                                                                            UNION ALL
                                                                                            SELECT corporate_agency_id AS suser_id FROM `corporate_agency` WHERE reference_no = ?
                                                                                            UNION ALL
                                                                                            SELECT institution_id AS suser_id FROM `institution` WHERE reference_no = ?  ");
                                                                    $stmt3->execute([$userId,$userId,$userId]);
                                                                    $userCAs = $stmt3->fetchAll(PDO::FETCH_ASSOC);

                                                                    foreach($userCAs as $userCA){
                                                                        $userCAID = $userCA['suser_id'];
                                                                        // echo $userCA;

                                                                        $stmt4 = $conn->prepare("SELECT ca_travelagency_id AS user_id FROM ca_travelagency WHERE reference_no = ?
                                                                                                UNION ALL
                                                                                                SELECT institution_branch_manager_id AS user_id FROM institution_branch_manager WHERE reference_no = ?");
                                                                        $stmt4->execute([$userCA['suser_id'],$userCA['suser_id']]);
                                                                        $userCATAs = $stmt4->fetchAll(PDO::FETCH_ASSOC);

                                                                        foreach ($userCATAs as $userCATA) {
                                                                            $userTA = $userCATA['user_id'];
                                                                            //    echo $userCA.'=>'.$userTA.'</br>';

                                                                            $stmt5 = $conn->prepare("SELECT * FROM ca_customer WHERE ta_reference_no = ? AND (status ='1' OR status = '3') ");
                                                                            $stmt5->execute([$userCATA['user_id']]);
                                                                            $userCACUs = $stmt5->fetchAll(PDO::FETCH_ASSOC);

                                                                            foreach ($userCACUs as $userCACU) {
                                                                                $userCU = $userCACU['id'];
                                                                                // echo $userId.'=>'.$userCA.'=>'.$userTA.'=>'.$userCU.'</br>';
                                                                                $comp_chek = $userCACU['comp_chek'] == '1' ? 'complimentary' : 'Noncomplimentary'; 
                                                                                $bd= new DateTime($userCACU['date_of_birth']);
                                                                                $bdate= $bd->format('d-m-Y');
                                                                                $dt= new DateTime($userCACU['register_date']);
                                                                                $datev= $dt->format('d-m-Y'); 
                                                                                echo'<tr>
                                                                                    <td>
                                                                                        <p>'.$userCACU['ca_customer_id'].'</p>
                                                                                        <p>'.$userCACU['firstname'].' '.$userCACU['lastname'].'</p>
                                                                                    </td>
                                                                                    <td>
                                                                                        <p>'.$userCACU['reference_no'].' '.$userCACU['registrant'].'</p>
                                                                                        <p>'.$userCACU['ta_reference_no'].' '.$userCACU['ta_reference_name'].'</p>
                                                                                    </td>
                                                                                    <td>
                                                                                        <p class="mb-0">'.$userCACU['customer_type'].'</p>
                                                                                        <p class="mb-0">'.$comp_chek.'</p>
                                                                                    </td>
                                                                                    <td>'.$userCACU['contact_no'].'</td>
                                                                                    <td>'.$datev.'</td>';
                                                                                    if($userCACU['status'] == '1')
                                                                                        echo'<td><span class="badge bg-success">Active</span></td>';
                                                                                    else{
                                                                                        echo'<td><span class="badge bg-danger">Deactive</span></td>';
                                                                                    }
                                                                                echo'</tr>';
                                                                            }
                                                                        }   
                                                                    }
                                                                    //RM->TC->CU
                                                                    $stmt4 = $conn->prepare("SELECT ca_travelagency_id FROM ca_travelagency WHERE reference_no = ?");
                                                                    $stmt4->execute([$userId]);
                                                                    $userCATAs = $stmt4->fetchAll(PDO::FETCH_ASSOC);

                                                                    foreach ($userCATAs as $userCATA) {
                                                                        $userTA = $userCATA['ca_travelagency_id'];

                                                                        $stmt5 = $conn->prepare("SELECT * FROM ca_customer WHERE ta_reference_no = ? AND (status ='1' OR status = '3') ");
                                                                        $stmt5->execute([$userCATA['ca_travelagency_id']]);
                                                                        $userCACUs = $stmt5->fetchAll(PDO::FETCH_ASSOC);

                                                                        foreach ($userCACUs as $userCACU) {
                                                                            $userCU = $userCACU['id'];
                                                                            // echo $userId.'=>'.$userCA.'=>'.$userTA.'=>'.$userCU.'</br>';
                                                                            $comp_chek = $userCACU['comp_chek'] == '1' ? 'complimentary' : 'Noncomplimentary'; 
                                                                            $bd= new DateTime($userCACU['date_of_birth']);
                                                                            $bdate= $bd->format('d-m-Y');
                                                                            $dt= new DateTime($userCACU['register_date']);
                                                                            $datev= $dt->format('d-m-Y'); 
                                                                            echo'<tr>
                                                                                <td>
                                                                                    <p>'.$userCACU['ca_customer_id'].'</p>
                                                                                    <p>'.$userCACU['firstname'].' '.$userCACU['lastname'].'</p>
                                                                                </td>
                                                                                <td>
                                                                                    <p>'.$userCACU['reference_no'].' '.$userCACU['registrant'].'</p>
                                                                                    <p>'.$userCACU['ta_reference_no'].' '.$userCACU['ta_reference_name'].'</p>
                                                                                </td>
                                                                                <td>
                                                                                    <p class="mb-0">'.$userCACU['customer_type'].'</p>
                                                                                    <p class="mb-0">'.$comp_chek.'</p>
                                                                                </td>
                                                                                <td>'.$userCACU['contact_no'].'</td>
                                                                                <td>'.$datev.'</td>';
                                                                                if($userCACU['status'] == '1')
                                                                                    echo'<td><span class="badge bg-success">Active</span></td>';
                                                                                else{
                                                                                    echo'<td><span class="badge bg-danger">Deactive</span></td>';
                                                                                }
                                                                            echo'</tr>';
                                                                        }
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
                            
                            </div>

                        </div>
                        <?php if($userType == "10" || $userType == "11" ||$userType == "3" || $userType == "33" ){ ?>
                            <div class="btn" style="width: 25px; height: 25px; padding: 0px; position: fixed; bottom: 120px; right: 35px; border-radius: 50%;">
                                <a href="add_customer.php" style="display: flex; justify-content: center; align-items: center; height: -webkit-fill-available;">
                                    <i class="fa-solid fa-circle-plus fa-beat-fade fa-3x" style="color: #4b38b3;"></i>
                                </a>
                            </div>
                        <?php } ?> 

                    </div> <!-- container-fluid -->

                </div><!-- End Page-content -->
                <?php 
                    include_once(__DIR__ . '/customer_footer.php');
                ?>
                
            </div><!-- end main content-->
        
        </div><!-- END layout-wrapper -->

        <!--start back-to-top-->
        <button onclick="topFunction()" class="scrollToTop scroll-btn show btn" id="back-to-top">
            <i class="ri-arrow-up-line"></i>
        </button>
        <!--end back-to-top-->
        <?php include (__DIR__ .'/../contact_modal.php') ?>
        <!-- JAVASCRIPT -->
        <script src="../assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
        <script src="../assets/libs/simplebar/simplebar.min.js"></script>
        <script src="../assets/libs/node-waves/waves.min.js"></script>
        <script src="../assets/libs/feather-icons/feather.min.js"></script>
        <script src="../assets/js/jquery/jquery-3.7.1.min.js"></script>

        <!-- Required datatable js -->
        <script src="../assets/libs/datatables.net/js/jquery.dataTables.min.js"></script>
        <script src="../assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>
        
        <!-- Responsive examples -->
        <script src="../assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
        <script src="../assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js"></script>
        <!-- !-- materialdesign icon js- -->
        <script src="../assets/js/pages/remix-icons-listing.js"></script>
        
        <!-- Vector map-->
        <script src="<?= $base_url ?>../assets/libs/jsvectormap/js/jsvectormap.min.js"></script>
        <script src="<?= $base_url ?>../assets/libs/jsvectormap/maps/world-merc.js"></script>

        <!--Swiper slider js-->
        <script src="<?= $base_url ?>../assets/libs/swiper/swiper-bundle.min.js"></script>
        

        <!-- App js -->
        <script src="../assets/js/app.js"></script>

        <script>
            $(document).ready(function(){
                $("#example-dataTable").DataTable();
                $("#example-dataTable-2").DataTable();
            });

            function editfunc(id,cut,st,ct,editfor){
                window.location.href='edit_customer.php?vkvbvjfgfikix='+id+'&ncy='+cut+'&mst='+st+'&hct='+ct+'&editfor='+editfor;
            };

            function addRefFunc(id,taID,cut,st,ct,editfor){
                window.location.href='add_customer.php?vkvbvjfgfikix='+id+'&taId='+taID+'&ncy='+cut+'&mst='+st+'&hct='+ct+'&editfor='+editfor;
            };
            
            function deletefunc(id,refid,action,userId,userType){
                var dataString = 'id='+id+'&refid='+refid+'&action='+action+'&userId='+userId+'&userType='+userType

                $.ajax({
                    type: "POST",
                    url: "customer/delete_customer_data.php",
                    data: dataString,
                    cache: false,
                    success:function(data){
                        console.log(data);
                        if( data == 0 ){
                            alert("Deleted Succesfully");
                            window.location.reload();
                        }else if( data == 1 ){
                            alert("User Activated Succesfully");
                            window.location.reload();
                        }else if( data == 2 ){
                            alert("User Restored Succesfully");
                            window.location.reload();
                        }else if( data == 3 ){
                            alert("User Deactivated Succesfully");
                            window.location.reload();
                        } else {
                            alert("Request Failed !!");
                        }
                    }
                });
            };

            function confirmfunc(id,email){ 
                var dataString = 'id='+ id+'&uname='+email;

                $.ajax({
                    type: "POST",
                    url: "customer/confirm_customer.php",
                    data: dataString,
                    cache: false,
                    success:function(data){
                        if(data == 1){
                            alert("Email and Password sent via sms and email");
                        window.location.reload();
                    }
                    else{

                    alert("Failed to confirm");
                    }
                }
                });
                
            };

            function overviewPage(id,ref,cut,st,ct,message){
                var designation = 'ca_customer';
                window.location.href='overview.php?id='+id+'&ref='+ref+'&cut='+cut+'&st='+st+'&ct='+ct+'&message='+message+'&designation='+designation;
            }
        </script>
        <!-- dialer logic scripts -->
        <script>
            document.addEventListener("DOMContentLoaded", function () {

                const callBtn = document.getElementById("callBtn");

                if (callBtn) {
                    callBtn.addEventListener("click", function(e) {

                        let isMobile = /iPhone|iPad|iPod|Android/i.test(navigator.userAgent);

                        if (!isMobile) {
                            e.preventDefault();

                            alert("📞 Calling works only on mobile devices.\nPlease dial 8010892265 from your phone.");
                            location.reload();

                            // Optional clipboard copy (safe fallback)
                            if (navigator.clipboard) {
                                navigator.clipboard.writeText("8010892265");
                            }
                        }
                    });
                }

            });
        </script>

        <script>
            var modal = document.getElementById('staticBackdrop');

            // Store the element that opened the modal
            let lastFocusedElement;

            document.addEventListener('click', function(e) {
                if (e.target.closest('[data-bs-toggle="modal"]')) {
                    lastFocusedElement = e.target;
                }
            });

            modal.addEventListener('hidden.bs.modal', function () {
                if (lastFocusedElement) {
                    lastFocusedElement.focus();
                } else {
                    document.body.focus();
                }
            });
        </script>
        <!-- end dialer logic scripts -->
    </body>
</html>