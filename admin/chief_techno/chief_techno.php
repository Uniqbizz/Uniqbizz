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
        <title>Chief Techo Enterprise | Admin Dashboard </title>
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
        <!-- Loading Screen and Images size css  -->
        <link rel="stylesheet" href="../assets/css/loadingScreen.css" rel="stylesheet" type="text/css" />
        <!-- App js -->
        <!-- <script src="../assets/js/plugin.js"></script> -->
        <!-- Font awesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />   
        <!-- Date Range Picker CSS Start -->
        <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
        <!-- Select2 CSS -->
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />         

        <style>
            /* dataTable, action col, dropdown align right  */

            @media screen and (max-width: 1191px) {
                .dropdown-menu-end-1[style] {
                    left: 25%!important;
                    right: 25%!important;
                }
            }
            @media screen and (max-width: 991px) and (min-width: 941px) {
                .dropdown-menu-end-1[style] {
                    left: -250%!important;
                    right: -250%!important;
                    width: 80px !important;
                }
            }
            @media screen and (max-width: 1345px) and (min-width: 1264px) {
                .dropdown-menu-end-2[style] {
                    left: 25%!important;
                    right: 25%!important;
                }
            }

        </style>

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
                    <div class="container-fluid">
                        
                        <!-- start page title -->
                        <div class="row">
                            <div class="col-12">
                                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                    <h4 class="mb-sm-0 font-size-18">Chief Techo Enterprise</h4>
                                </div>
                            </div>
                        </div>
                        <!-- end page title -->

                         <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row mb-2">
                                            <div class="col-sm-12">
                                                <div class="search-box me-2 mb-2 d-inline-block">
                                                    <div class="position-relative">
                                                        <h4>Pending Chief Techo Enterprise List</h4>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="table-responsive">
                                            <table class="table align-middle table-nowrap dt-responsive nowrap w-100" id="pendingCustomerList-table">
                                                <thead class="table-light">
                                                    <tr>
                                                        <th>Id</th>
                                                        <th>Full Name</th>
                                                        <th>Reference ID / Name</th>
                                                        <th>Phone / Email</th>
                                                        <th>Address</th>
                                                        <th>Joining Date</th>
                                                        <th>Status</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                        $sql = "
                                                            SELECT
                                                                cte.*,
                                                                uv.status AS verification_status
                                                            FROM chief_techno_enterprise cte
                                                            LEFT JOIN (
                                                                SELECT uv1.application_id, uv1.status
                                                                FROM user_verification uv1
                                                                INNER JOIN (
                                                                    SELECT application_id, MAX(id) AS max_id
                                                                    FROM user_verification
                                                                    GROUP BY application_id
                                                                ) uv2
                                                                ON uv1.id = uv2.max_id
                                                            ) uv
                                                            ON cte.application_id = uv.application_id
                                                            WHERE cte.status IN ('0','2','4')
                                                            ORDER BY cte.id ASC
                                                        ";
                                                        $stmt = $conn->prepare($sql);
                                                        $stmt->execute();
                                                        $stmt->setFetchMode(PDO::FETCH_ASSOC);

                                                        if ($stmt->rowCount() > 0) {
                                                            foreach ($stmt->fetchAll() as $key => $row) {
                                                                
                                                                $bd = new DateTime($row['date_of_birth']);
                                                                $bdate = $bd->format('d-m-Y');

                                                                $rd = new DateTime($row['added_on']);
                                                                $rdate = $rd->format('d-m-Y');

                                                                // $label = $row['user_type'] == 'BM' ? '<span class="badge bg-primary me-1">BM</span>' : '<span class="badge bg-success me-1">MF</span>';
                                                                switch ($row['user_type']) {
                                                                    case 'CTE':
                                                                        $label = '<span class="badge bg-primary me-1">CTE</span>';
                                                                        break;
                                                                    default:
                                                                        $label = '';
                                                                }

                                                                echo '<tr>
                                                                    <td>' . $row['id'] . '</td>
                                                                    <td>' . $label . $row['firstname'] . ' ' . $row['lastname'] . '</td>
                                                                    <td><p class="mb-1">' . $row['reference_no'] . '</p>
                                                                        <p class="mb-0">' . $row['registrant'] . '</p>
                                                                    </td>
                                                                    <td>
                                                                        <p class="mb-1">+' . $row['country_code'] . ' ' . $row['contact_no'] . '</p>
                                                                        <p class="mb-0">' . $row['email'] . '</p>
                                                                    </td>
                                                                    <td>' . $row['address'] . '</td>
                                                                    <td>' . $rdate . '</td>';

                                                                if ($row['status'] == '2') {
                                                                    switch ($row['verification_status']) {
                                                                        case '1':
                                                                            $verificationLabel = '<span class="badge bg-success me-1">Approved</span>';
                                                                            break;
                                                                        case '2':
                                                                            $verificationLabel = '<span class="badge bg-danger me-1">Correction <br/> Required</span>';
                                                                            break;
                                                                        default:
                                                                            $verificationLabel = '<span class="badge text-bg-warning">Pending</span>';
                                                                    }
                                                                    echo '<td>'.$verificationLabel.'</td>';
                                                                    echo '<td>
                                                                        <div class="dropdown">
                                                                            <a href="#" class="dropdown-toggle card-drop" data-bs-toggle="dropdown" aria-expanded="false">
                                                                                <i class="mdi mdi-dots-horizontal font-size-18"></i>
                                                                            </a>
                                                                            <ul class="dropdown-menu dropdown-menu-right dropdown-menu-end-1">
                                                                                <li>
                                                                                    <a href="#" 
                                                                                        onclick=\'editfuncCust(
                                                                                                                "' . $row["id"] . '",
                                                                                                                "' . $row["reference_no"] . '",
                                                                                                                "' . $row["register_by"] . '",
                                                                                                                "' . $row["country"] . '",
                                                                                                                "' . $row["state"] . '",
                                                                                                                "' . $row["city"] . '",
                                                                                                                "pending",
                                                                                                                "' . strtolower($row['user_type']) . '"
                                                                                                                )\' 
                                                                                                                class="dropdown-item" data-bs-toggle="modal" >
                                                                                                                    <i class="mdi mdi-pencil font-size-16 text-primary me-1"></i> Edit
                                                                                    </a>
                                                                                </li>
                                                                                <li>
                                                                                    <a href="#" 
                                                                                        onclick=\'deletefunc(
                                                                                                                "' . $row["id"] . '",
                                                                                                                "","pending",
                                                                                                                "' . strtolower($row['user_type']) . '"
                                                                                                                )\' 
                                                                                                                class="dropdown-item" data-bs-toggle="modal" >
                                                                                                                    <i class="mdi mdi-trash-can font-size-16 text-danger me-1"></i> Delete
                                                                                    </a>
                                                                                </li>
                                                                                <li>
                                                                                    <a href="#" 
                                                                                        onclick=\'confirmfunc(
                                                                                                                "' . $row["id"] . '",
                                                                                                                "' . $row["email"] . '",
                                                                                                                "' . strtolower($row['user_type']) . '"
                                                                                                                )\' 
                                                                                                                class="dropdown-item" data-bs-toggle="modal" >
                                                                                                                    <i class="fas fa-check-circle font-size-16 text-success me-1"></i> Confirm
                                                                                    </a>
                                                                                </li>
                                                                            </ul>
                                                                        </div>
                                                                    </td>';
                                                                } else if ($row['status'] == '0') {
                                                                    echo '<td><span class="badge text-bg-danger">Delete</span></td>
                                                                    <td>
                                                                        <div class="dropdown">
                                                                            <a href="#" class="dropdown-toggle card-drop" data-bs-toggle="dropdown" aria-expanded="false">
                                                                                <i class="mdi mdi-dots-horizontal font-size-18"></i>
                                                                            </a>
                                                                            <ul class="dropdown-menu dropdown-menu-right dropdown-menu-end-1">
                                                                                <li>
                                                                                    <a href="#" 
                                                                                        onclick=\'deletefunc(
                                                                                                                "' . $row["id"] . '",
                                                                                                                "","deleted",
                                                                                                                "' . strtolower($row['user_type']) . '"
                                                                                                                )\' 
                                                                                                                class="dropdown-item" data-bs-toggle="modal" >
                                                                                                                    <i class="mdi mdi-file-restore font-size-16 text-success me-1"></i> Restore
                                                                                    </a>
                                                                                </li>
                                                                            </ul>
                                                                        </div>
                                                                    </td>';
                                                                } else if ($row['status'] == '4') {
                                                                    echo '<td><span class="badge text-bg-primary">Draft</span></td>
                                                                    <td>
                                                                        <div class="dropdown">
                                                                            <a href="#" class="dropdown-toggle card-drop" data-bs-toggle="dropdown" aria-expanded="false">
                                                                                <i class="mdi mdi-dots-horizontal font-size-18"></i>
                                                                            </a>
                                                                            <ul class="dropdown-menu dropdown-menu-right dropdown-menu-end-1">
                                                                                <li>
                                                                                    <a href="#" 
                                                                                        onclick=\'editfuncCust(
                                                                                                                "' . $row["id"] . '",
                                                                                                                "' . $row["reference_no"] . '",
                                                                                                                "' . $row["register_by"] . '",
                                                                                                                "' . $row["country"] . '",
                                                                                                                "' . $row["state"] . '",
                                                                                                                "' . $row["city"] . '",
                                                                                                                "pending",
                                                                                                                "' . strtolower($row['user_type']) . '"
                                                                                                                )\' 
                                                                                                                class="dropdown-item" data-bs-toggle="modal" >
                                                                                                                    <i class="mdi mdi-pencil font-size-16 text-primary me-1"></i> View / Edit
                                                                                    </a>
                                                                                </li>
                                                                                <li>
                                                                                    <a href="#" 
                                                                                        onclick=\'deletefunc(
                                                                                                                "' . $row["id"] . '",
                                                                                                                "","pending",
                                                                                                                "' . strtolower($row['user_type']) . '"
                                                                                                                )\' 
                                                                                                                class="dropdown-item" data-bs-toggle="modal" >
                                                                                                                    <i class="mdi mdi-trash-can font-size-16 text-danger me-1"></i> Delete
                                                                                    </a>
                                                                                </li>
                                                                                
                                                                            </ul>
                                                                        </div>
                                                                    </td>';
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
                        <!-- end row -->

                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row mb-2">
                                            <div class="col-sm-6">
                                                <div class="search-box me-2 mb-2 d-inline-block">
                                                    <div class="position-relative">
                                                        <h4>Registered Chief Techo Enterprise List</h4>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- end col-->
                                            <!-- Search Filter -->
                                            <div class="row filter-row p-2">
                                                <!-- <div class="col-sm-3 col-md-3"> 
                                                    <div class="input-block mb-3">
                                                        <label class="col-form-label"><span>Desigantion</span></label>
                                                        <select class="form-control Fileter-list" id="designation_value" aria-label=" Floating label select example"> 
                                                            <option value="All">All</option>
                                                            <option value="BM">Business Mentor</option>
                                                            <option value="MF">Master Franchisee</option>
                                                            <option value="SF">Sponsor Franchisee</option>
                                                            <option value="CTE">Chief Techno Enterprise</option>
                                                        </select>
                                                        
                                                    </div>
                                                </div> -->
                                                <!-- <div class="col-sm-4 col-md-4"> 
                                                    <div class="input-block mb-3">
                                                        <label class="col-form-label"><span>Branch</span></label>
                                                        <select class="form-control Fileter-list" id="filter_branch" aria-label=" Floating label select example"> 
                                                            <option value="">--- Select ---</option>
                                                            <?php
                                                                // require '../connect.php';
                                                                // $sql = "SELECT * FROM `branch` WHERE status ='1' ";
                                                                // $stmt = $conn->prepare($sql);
                                                                // $stmt -> execute();
                                                                // $stmt -> setFetchMode(PDO::FETCH_ASSOC);
                                                                // if($stmt-> rowCount()>0 ){
                                                                //     foreach( ($stmt -> fetchAll()) as $key => $row ){
                                                                //         echo'
                                                                //             <option value="'.$row['id'].'">'.$row['branch_name'].'</option>
                                                                //         ';
                                                                //     }
                                                                // }else{
                                                                //     echo '<option value="">Department not available</option>'; 
                                                                // }
                                                            ?>
                                                        </select>
                                                    </div>    
                                                </div> -->
                                                
                                                <!-- date range -->
                                                <div class="col-md-6 col-sm-4">
                                                    <label class="col-form-label"><span>Date Range</span></label>
                                                    <div id="reportrange" class="Fileter-list input-block text-dark px-3 py-2 w-100 text-center dateRange " style="background-color:#e5e5e5; border-radius: 6px;">
                                                        <i class="fa fa-calendar"></i>&nbsp;
                                                        <span id='selectedDate'></span> <i class="fa-solid fa-angle-down"></i>
                                                    </div>
                                                </div>

                                                <div class="col-sm-2 col-md-4"> 
                                                    <div class="input-block mb-3">
                                                        <label class="col-form-label" for=""><span>Count</span></label>
                                                        <input type="text" name="" id="filterCount" class="form-control" readonly>
                                                    </div>
                                                </div>
                                                <div class="col-sm-2 col-md-2" id="download_icon">
                                                    <div class="input-block mb-3 pt-4 mt-2">
                                                        <button type="button" onclick="regTcDownload()" class="btn bg-primary text-white mb-3">Download</button>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Search Filter -->
                                        </div>
                                        
                                        <div class="table-responsive" id="bmView">
                                            <table class="table align-middle table-nowrap dt-responsive nowrap w-100" id="registeredCustomerList-table">
                                                <thead class="table-light">
                                                    <tr>
                                                        <th>CTE Id</th>
                                                        <th>Full Name</th>
                                                        <th>Reference ID / Name</th>
                                                        <th>Phone / Email</th>
                                                        <!-- <th>Branch</th> -->
                                                        <th>Amt</th>
                                                        <th>Joining Date</th>
                                                        <th>Status</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                        $sql = "
                                                            SELECT chief_techno_enterprise_id as user_id,firstname,lastname,reference_no,registrant,country_code,
                                                            email,paid_amount,register_date,date_of_birth,country,state,city,contact_no,register_by,id, 
                                                            'CTE' AS user_type FROM chief_techno_enterprise WHERE status IN ('1')
                                                        ";
                                                        $stmt = $conn->prepare($sql);
                                                        $stmt->execute();
                                                        $stmt->setFetchMode(PDO::FETCH_ASSOC);

                                                        if ($stmt->rowCount() > 0) {
                                                            foreach ($stmt->fetchAll() as $key => $row) {
                                                                $bd = new DateTime($row['date_of_birth']);
                                                                $bdate = $bd->format('d-m-Y');

                                                                $rd = new DateTime($row['register_date']);
                                                                $rdate = $rd->format('d-m-Y');

                                                                // $branchID = $row['branch'];
                                                                // $branch = '';

                                                                // $sqlBranch = "SELECT branch_name FROM branch WHERE id = ?";
                                                                // $stmtId = $conn->prepare($sqlBranch);
                                                                // $stmtId->execute([$branchID]);
                                                                // if ($stmtId->rowCount() > 0) {
                                                                //     $branchData = $stmtId->fetch(PDO::FETCH_ASSOC);
                                                                //     $branch = $branchData['branch_name'];
                                                                // }

                                                                $label = $row['user_type'] === 'CTE'
                                                                    ? '<span class="badge bg-primary me-1">CTE</span>':'NA';

                                                            echo '<tr>
                                                                    <td>' . $row['user_id'] . '</td>
                                                                    <td>' . $label . $row['firstname'] . ' ' . $row['lastname'] . '</td>
                                                                    <td><p class="mb-1">' . $row['reference_no'] . '</p>
                                                                        <p class="mb-0">' . $row['registrant'] . '</p>
                                                                    </td>
                                                                    <td>
                                                                        <p class="mb-1">+' . $row['country_code'] . ' ' . $row['contact_no'] . '</p>
                                                                        <p class="mb-0">' . $row['email'] . '</p>
                                                                    </td>
                                                                    <td>' . $row['paid_amount'] . '</td>
                                                                    <td>' . $rdate . '</td>';

                                                                echo'<td><span class="badge text-bg-success">Active</span></td>
                                                                    <td>
                                                                        <div class="dropdown">
                                                                            <a href="#" class="dropdown-toggle card-drop" data-bs-toggle="dropdown" aria-expanded="false">
                                                                                <i class="mdi mdi-dots-horizontal font-size-18"></i>
                                                                            </a>
                                                                            <ul class="dropdown-menu dropdown-menu-right dropdown-menu-end-2">
                                                                                <li>
                                                                                    <a href="#" 
                                                                                        onclick=\'overviewPage(
                                                                                            "' . $row["user_id"] . '",
                                                                                            "' . $row["reference_no"] . '",
                                                                                            "' . $row["country"] . '",
                                                                                            "' . $row["state"] . '",
                                                                                            "' . $row["city"] . '",
                                                                                            "' . (strtolower($row["user_type"]) == "cte" 
                                                                                                    ? "chief_techno_enterprise" 
                                                                                                    : "NA") . '"
                                                                                        )\' 
                                                                                        class="dropdown-item" 
                                                                                        data-bs-toggle="modal">
                                                                                            <i class="mdi mdi-eye font-size-16 text-info me-1"></i> View
                                                                                    </a>
                                                                                </li>
                                                                                <li>
                                                                                    <a href="#" onclick=\'editfuncCust(
                                                                                                                        "' . $row["user_id"] . '",
                                                                                                                        "' . $row["reference_no"] . '",
                                                                                                                        "' . $row["register_by"] . '",
                                                                                                                        "' . $row["country"] . '",
                                                                                                                        "' . $row["state"] . '",
                                                                                                                        "' . $row["city"] . '",
                                                                                                                        "registered",
                                                                                                                        "' . strtolower($row['user_type']) . '"
                                                                                                                        )\' 
                                                                                                                        class="dropdown-item" data-bs-toggle="modal" >
                                                                                                                            <i class="mdi mdi-pencil font-size-16 text-primary me-1"></i> Edit
                                                                                    </a>
                                                                                </li>
                                                                                <li>
                                                                                    <a href="#" onclick=\'deletefunc(
                                                                                                                        "' . $row["id"] . '",
                                                                                                                        "' . $row["user_id"] . '",
                                                                                                                        "registered",
                                                                                                                        "' . strtolower($row['user_type']) . '"
                                                                                                                        )\' 
                                                                                                                        class="dropdown-item" data-bs-toggle="modal" >
                                                                                                                            <i class="mdi mdi-trash-can font-size-16 text-danger me-1"></i> Delete
                                                                                    </a>
                                                                                </li>
                                                                            </ul>
                                                                        </div>
                                                                    </td>';

                                                            echo '</tr>';
                                                            }
                                                        }
                                                    ?>

                                                </tbody>
                                            </table>
                                            <!-- end table -->
                                        </div>
                                        
                                        <!-- end table responsive -->
                                    </div>
                                    <!-- end card body -->
                                </div>
                                <!-- end card -->
                            </div>
                            <!-- end col -->
                        </div>
                        <!-- end row -->
                        <!--Deleted Users-->
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row mb-2">
                                            <div class="col-sm-6">
                                                <div class="search-box me-2 mb-2 d-inline-block">
                                                    <div class="position-relative">
                                                        <h4>Deleted Chief Techo Enterprise List</h4>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                        </div>
                                        
                                        <div class="table-responsive" id="bmView">
                                            <table class="table align-middle table-nowrap dt-responsive nowrap w-100" id="deletedCustomerList-table">
                                                <thead class="table-light">
                                                    <tr>
                                                        <th>CTE Id</th>
                                                        <th>Full Name</th>
                                                        <th>Reference ID / Name</th>
                                                        <th>Phone / Email</th>
                                                        <!-- <th>Branch</th> -->
                                                        <th>Amt</th>
                                                        <th>Joining Date</th>
                                                        <th>Status</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                        $sql = "
                                                            SELECT *, 'CTE' AS user_type FROM chief_techno_enterprise WHERE status IN ('3')
                                                            
                                                        ";
                                                        $stmt = $conn->prepare($sql);
                                                        $stmt->execute();
                                                        $stmt->setFetchMode(PDO::FETCH_ASSOC);

                                                        if ($stmt->rowCount() > 0) {
                                                            foreach ($stmt->fetchAll() as $key => $row) {
                                                                $bd = new DateTime($row['date_of_birth']);
                                                                $bdate = $bd->format('d-m-Y');

                                                                $rd = new DateTime($row['register_date']);
                                                                $rdate = $rd->format('d-m-Y');

                                                                // $branchID = $row['branch'];
                                                                // $branch = '';

                                                                // $sqlBranch = "SELECT branch_name FROM branch WHERE id = ?";
                                                                // $stmtId = $conn->prepare($sqlBranch);
                                                                // $stmtId->execute([$branchID]);
                                                                // if ($stmtId->rowCount() > 0) {
                                                                //     $branchData = $stmtId->fetch(PDO::FETCH_ASSOC);
                                                                //     $branch = $branchData['branch_name'];
                                                                // }

                                                                $label = $row['user_type'] === 'CTE'
                                                                    ? '<span class="badge bg-primary me-1">CTE</span>':'NA';

                                                            echo '<tr>
                                                                    <td>' . $row['chief_techno_enterprise_id'] . '</td>
                                                                    <td>' . $label . $row['firstname'] . ' ' . $row['lastname'] . '</td>
                                                                    <td><p class="mb-1">' . $row['reference_no'] . '</p>
                                                                        <p class="mb-0">' . $row['registrant'] . '</p>
                                                                    </td>
                                                                    <td>
                                                                        <p class="mb-1">+' . $row['country_code'] . ' ' . $row['contact_no'] . '</p>
                                                                        <p class="mb-0">' . $row['email'] . '</p>
                                                                    </td>
                                                                    <td>' . $row['paid_amount'] . '</td>
                                                                    <td>' . $rdate . '</td>';

                                                                echo'<td><span class="badge text-bg-danger">Deactive</span></td>
                                                                    <td>
                                                                        <div class="dropdown">
                                                                            <a href="#" class="dropdown-toggle card-drop" data-bs-toggle="dropdown" aria-expanded="false">
                                                                                <i class="mdi mdi-dots-horizontal font-size-18"></i>
                                                                            </a>
                                                                            <ul class="dropdown-menu dropdown-menu-right dropdown-menu-end-2">
                                                                                <li>
                                                                                    <a href="#" 
                                                                                        onclick=\'deletefunc(
                                                                                                                "' . $row["id"] . '",
                                                                                                                "' . $row["chief_techno_enterprise_id"] . '",
                                                                                                                "deactivate","' . strtolower($row['user_type']) . '"
                                                                                                                )\' 
                                                                                                                class="dropdown-item" data-bs-toggle="modal" >
                                                                                                                    <i class="mdi mdi-file-restore font-size-16 text-success me-1"></i> Restore
                                                                                    </a>
                                                                                </li>
                                                                            </ul>
                                                                        </div>
                                                                    </td>';

                                                            echo '</tr>';
                                                            }
                                                        }
                                                    ?>

                                                </tbody>
                                            </table>
                                            <!-- end table -->
                                        </div>
                                        
                                        <!-- end table responsive -->
                                    </div>
                                    <!-- end card body -->
                                </div>
                                <!-- end card -->
                            </div>
                            <!-- end col -->
                        </div>
                        <!-- end row -->
                        <!--end Deleted Users-->

                    </div> <!-- container-fluid -->
                </div> <!-- End Page-content -->

                
                <?php include_once "../footer.php" ?>
            </div>
            <!-- end main content-->

        </div>
        <!-- END layout-wrapper -->
        
        <!-- loading screen -->
        <div id="loading-overlay">
            <div class="loading-icon"></div>
        </div>
        <!-- Add button icon -->
        <div class="btn" data-bs-toggle="modal" data-bs-target="#newBusinessOperationChiefModal" style="width: 25px; height: 25px; padding: 0px; position: fixed; bottom: 120px; right: 43px; border-radius: 50%;">
            <a style="display: flex; justify-content: center; align-items: center; height: -webkit-fill-available;">
                <i class="fa-solid fa-circle-plus fa-beat-fade fa-3x" style="color: #4b38b3;"></i>
            </a>
        </div>
        <!--start back-to-top-->
        <button onclick="topFunction()" class="scrollToTop scroll-btn show btn" id="back-to-top">
            <i class="mdi mdi-arrow-up"></i>
        </button>
        <!--end back-to-top-->

        <!-- Modal -->
        <div class="modal fade" id="newBusinessOperationChiefModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-sm">
                <div class="modal-content">
                    <div class="modal-body px-4 py-5 text-center">
                        <button type="button" class="btn-close position-absolute end-0 top-0 m-3" data-bs-dismiss="modal" aria-label="Close"></button>
                        <div class="avatar-sm mb-4 mx-auto">
                            <div class="avatar-title bg-primary text-primary bg-opacity-10 font-size-20 rounded-3">
                                <span class="avatar-title">
                                    <i class="fas fa-user-alt font-size-24"></i>
                                </span>
                            </div>
                        </div>
                        <p class="text-muted font-size-16 mb-4">Are you Sure You want to Add New User ?</p>
                        
                        <div class="hstack gap-2 justify-content-center mb-0">
                            <button type="button" class="btn btn-success" id="add-item"><a href="addChiefTechno.php"><span style="color: white;">Add Now</span></a></button>
                            <button type="button" class="btn btn-secondary" id="close-newBusinessOperationChiefModal" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end newBusinessOperationChiefModal -->

        <!-- Modal -->
        <div class="modal fade" id="removeItemModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-sm">
                <div class="modal-content">
                    <div class="modal-body px-4 py-5 text-center">
                        <button type="button" class="btn-close position-absolute end-0 top-0 m-3" data-bs-dismiss="modal" aria-label="Close"></button>
                        <div class="avatar-sm mb-4 mx-auto">
                            <div class="avatar-title bg-primary text-primary bg-opacity-10 font-size-20 rounded-3">
                                <i class="mdi mdi-trash-can-outline"></i>
                            </div>
                        </div>
                        <p class="text-muted font-size-16 mb-4">Are you Sure You want to Remove this User ?</p>
                        
                        <div class="hstack gap-2 justify-content-center mb-0">
                            <button type="button" class="btn btn-danger" id="remove-item">Remove Now</button>
                            <button type="button" class="btn btn-secondary" id="close-removeCustomerModal" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end removeItemModal -->

        <!-- Modal -->
        <div class="modal fade" id="confirmItemModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-sm">
                <div class="modal-content">
                    <div class="modal-body px-4 py-5 text-center">
                        <button type="button" class="btn-close position-absolute end-0 top-0 m-3" data-bs-dismiss="modal" aria-label="Close"></button>
                        <div class="avatar-sm mb-4 mx-auto">
                            <div class="avatar-title bg-primary text-primary bg-opacity-10 font-size-20 rounded-3">
                                <i class="fas fa-check-circle text-success"></i>
                            </div>
                        </div>
                        <p class="text-muted font-size-16 mb-4">Are you Sure You want to Cofirm this User ?</p>
                        
                        <div class="hstack gap-2 justify-content-center mb-0">
                            <button type="button" class="btn btn-success" id="remove-item">Confirm Now</button>
                            <button type="button" class="btn btn-secondary" id="close-confirmItemModal" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end confirmItemModal -->

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
        <!-- Moment.js -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment.min.js"></script>

        <!-- DataTables datetime sort plugin -->
        <script src="https://cdn.datatables.net/plug-ins/1.13.6/sorting/datetime-moment.js"></script>
        <!-- ecommerce-customer-list init -->
        <!-- <script src="../assets/js/pages/ecommerce-customer-list.init.js"></script> -->
        <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
        <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
        
        <!-- App js -->
        <script src="../assets/js/app.js"></script>

        <script>
            var mybutton = document.getElementById("back-to-top");
            function scrollFunction() {
                100 < document.body.scrollTop || 100 < document.documentElement.scrollTop ? mybutton.style.display = "block" : mybutton.style.display = "none"
            }
            function topFunction() {
                document.body.scrollTop = 0,
                document.documentElement.scrollTop = 0
            }
            mybutton && (window.onscroll = function() {
                scrollFunction()
            }
            );

        </script>

        <!-- dataTable -->
        <script>
            $(document).ready(function(){
                
                // Register the date format before using DataTables
                $.fn.dataTable.moment('DD-MM-YYYY');

                // Now initialize DataTables
                $("#pendingCustomerList-table").DataTable({
                    order: [[5, 'asc']] // 6th column = index 5
                });

                $("#registeredCustomerList-table").DataTable({
                    order: [[5, 'asc']]
                });
                
                $("#deletedCustomerList-table").DataTable({
                    order: [[5, 'asc']]
                });
            });
            
            function editfuncCust(id,refno,regby,cut,st,ct,editfor,usertype){ 
                window.location.href='editChiefTechno.php?id='+id+'&refno='+refno+'&regby='+regby+'&country='+cut+'&state='+st+'&city='+ct+'&editfor='+editfor+'&usertype='+usertype;
            };

            function deletefunc(id,fid,action,usertype){ 
                var dataString = 'id='+id+'&refid='+fid+'&action='+action+'&usertype='+usertype;

                $.ajax({
                type: "POST",
                url: "deleteChiefTechno.php",
                data: dataString,
                cache: false,
                    success:function(data){
                        // console.log('data'+data);
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

            function confirmfunc(id,email,usertype){ 

                var dataString = 'id='+ id+'&uname='+email+'&usertype='+usertype;
                $("#loading-overlay").show(); //loading screen
                $.ajax({
                    type: "POST",
                    url: "confirmChiefTechno.php",
                    data: dataString,
                    cache: false,
                    success:function(data){
                        if(data == 1){
                            $("#loading-overlay").hide(); //loading screen
                            alert("Email and Password sent via sms and email");
                            window.location.reload();
                        }
                        else{
                            $("#loading-overlay").hide(); //loading screen
                            alert("Failed to confirm");
                        }
                    }
                });
                
            };

            function overviewPage(id,ref,cut,st,ct,message){

                var designation = message == 'chief_techno_enterprise'?'Chief Techno Enterprise':'';
                window.location.href='../overview_profile/overview.php?id='+id+'&ref='+ref+'&cut='+cut+'&st='+st+'&ct='+ct+'&message='+message+'&designation='+designation;
            }
            
            // Global flag
            let dateRangeChanged = false;
            let fromDate = '', toDate = '';

            // On dropdown/filter change
            $('.Fileter-list').on('change', function(){
                reloadBMData();
            });

            // On date range apply
            $('#reportrange').on('apply.daterangepicker', function (ev, picker) {
                dateRangeChanged = true;
                fromDate = picker.startDate.format('DD-MM-YYYY');
                toDate   = picker.endDate.format('DD-MM-YYYY');
                $('#selectedDate').text(fromDate + ' to ' + toDate);

                reloadBMData(); // 🔥 reload table when date changes
            });

            // Reload function
            function reloadBMData(){
                // let filterDesig = $('#filter_branch').val();
                // let desig = $('#designation_value').val();

                // let dataString = 'branch='+filterDesig;
                let dataString = '';
                if (dateRangeChanged) {
                    dataString += '&fromDate='+fromDate+'&toDate='+toDate;
                }

                $.ajax({
                    type: 'POST',
                    url: 'filterSte.php',
                    data: dataString,
                    cache: false,
                    success: function(data){
                        if(data){
                            $('#bmView').html(data);
                            $("#registeredCustomerList-tableFilter").DataTable();
                            var totalRows = $("#registeredCustomerList-tableFilter").DataTable().rows().count();
                            $('#filterCount').val(totalRows);
                        }else{
                            $('#bmView').html(data);
                        }
                    }
                });
}

            //download excel
            function regTcDownload() {
                var branchVal  = $('#filter_branch').val() || "";
                // var designation = $('#designation_value').val()   || "";
                let fromDate = '', toDate = '';

                if (dateRangeChanged) {
                    const dateRange = $('#selectedDate').text().trim();
                    if (dateRange.includes(' to ')) {
                        [fromDate, toDate] = dateRange.split(' to ');
                    }
                }

                var params = new URLSearchParams({
                    branch: branchVal
                });

                if (dateRangeChanged && fromDate && toDate) {
                    params.append("fromDate", fromDate);
                    params.append("toDate", toDate);
                }

                window.location.href = "download_list.php?" + params.toString();
            }
            
        </script>
        <!-- Date Range Script -->
        <script type="text/javascript">
            $(function () {
                function cb(start, end) {
                    $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
                }

                $('#reportrange').daterangepicker({
                    autoUpdateInput: false, // prevents default range selection
                    ranges: {
                        'Today': [moment(), moment()],
                        'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                        'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                        'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                        'This Month': [moment().startOf('month'), moment().endOf('month')],
                        'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                    }
                }, cb);

                // Update input field manually when user selects range
                $('#reportrange').on('apply.daterangepicker', function(ev, picker) {
                    cb(picker.startDate, picker.endDate);
                });

                // Clear input when user cancels
                $('#reportrange').on('cancel.daterangepicker', function(ev, picker) {
                    $(this).find('span').html('');
                });
            });

        </script>
        <!-- Date Range Script -->

    </body>

</html>
