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
        <title>Institution View | Admin Dashboard </title>
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
        <link href="../assets/css/loadingScreen.css" rel="stylesheet" type="text/css" />

        <link href="../assets/css/ca_filter.css" rel="stylesheet" type="text/css" />
        <!-- App js -->
        <!-- <script src="../assets/js/plugin.js"></script> -->
        <!-- Font awesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />

        <style>
            /* dataTable, action col, dropdown align right  */
            .lable-width{
                width: 18px;
            }
            /* for tool tip of user indication */
            .tooltip-cell {
                position: relative;
            }

            .tooltip-msg {
                display: none;
                position: absolute;
                background: #717171;
                color: white;
                padding: 4px 8px;
                border-radius: 4px;
                top: -5px;
                left: 0;
                font-size: 12px;
                white-space: nowrap;
                z-index: 1;
            }

            .tooltip-cell:hover .tooltip-msg {
                display: block;
            }
            /* for tool tip of user indication */

            /* for tool tip of user indication */
            .tooltip-cell {
                position: relative;
            }
 
            .tooltip-msg {
                display: none;
                position: absolute;
                background: #717171;
                color: white;
                padding: 4px 8px;
                border-radius: 4px;
                top: -5px;
                left: 0;
                font-size: 12px;
                white-space: nowrap;
                z-index: 1;
            }
 
            .tooltip-cell:hover .tooltip-msg {
                display: block;
            }
            /* for tool tip of user indication */

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
                                    <h4 class="mb-sm-0 font-size-18">Institution</h4>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <!-- end page title -->

                        <!-- Pending list -->
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row mb-2">
                                            <div class="col-sm-6">
                                                <div class="search-box me-2 mb-2 d-inline-block">
                                                    <div class="position-relative">
                                                        <h4>Pending Institution List</h4>
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
                                                        <!-- <th>Address</th> -->
                                                        <th>Amount</th>
                                                        <th>Joining Date</th>
                                                        <th>Status</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                        $sql = "
                                                            SELECT 'in' AS user_type, id AS id, name, reference_no, registrant, country_code, contact_no, email, amount,  added_on, status, 
                                                            register_by, country, state, city,upgrade_status AS upgrade_status_val, 'NA' AS upgrade_id 
                                                            FROM institution 
                                                            WHERE status IN ('0', '2','4')
                                                            UNION ALL
                                                            SELECT 'in' AS user_type, i.institution_id AS id, i.name, i.reference_no, i.registrant, i.country_code, i.contact_no, i.email, i.amount, i.added_on, i.status, 
                                                            i.register_by, i.country, i.state, i.city,i.upgrade_status AS upgrade_status_val, iu.id AS upgrade_id
                                                            FROM institution i
                                                            LEFT JOIN institution_upgrade iu 
                                                                ON iu.institution_id = i.institution_id
                                                            WHERE 
                                                                i.status = 1 
                                                                AND i.upgrade_status = 1
                                            
                                                            ORDER BY added_on ASC
                                                        ";

                                                        $stmt = $conn->prepare($sql);
                                                        $stmt->execute();
                                                        $stmt->setFetchMode(PDO::FETCH_ASSOC);

                                                        if ($stmt->rowCount() > 0) {
                                                            foreach ($stmt->fetchAll() as $row) {
                                                                $bd = new DateTime($row['date_of_birth']);
                                                                $bdate = $bd->format('d-m-Y');

                                                                $rd = new DateTime($row['added_on']);
                                                                $rdate = $rd->format('d-m-Y');

                                                                echo '<tr>
                                                                    <td>' . $row['id'] . '</td>
                                                                    <td><span class="badge bg-secondary lable-width">' . strtoupper('i') . '</span>&nbsp' . ucfirst($row['firstname']) . ' ' . ucfirst($row['lastname']) . '</td>
                                                                    <td><p class="mb-1">' . $row['reference_no'] . '</p>
                                                                        <p class="mb-0">' . $row['registrant'] . '</p></td>
                                                                    <td>
                                                                        <p class="mb-1">+' . $row['country_code'] . ' ' . $row['contact_no'] . '</p>
                                                                        <p class="mb-0">' . $row['email'] . '</p>
                                                                    </td>
                                                                    <td>' . $row['amount'] . '</td>
                                                                    <td>' . $rdate . '</td>';

                                                                if ($row['status'] == '2') {
                                                                    echo '<td><span class="badge text-bg-warning">Pending</span></td>
                                                                        <td>
                                                                            <div class="dropdown">
                                                                                <a href="#" class="dropdown-toggle card-drop" data-bs-toggle="dropdown" aria-expanded="false">
                                                                                    <i class="mdi mdi-dots-horizontal font-size-18"></i>
                                                                                </a>
                                                                                <ul class="dropdown-menu">
                                                                                    <li><a href="#" onclick=\'editfuncCust("' . $row["id"] . '","' . $row["reference_no"] . '","' . $row["register_by"] . '","' . $row["country"] . '","' . $row["state"] . '","' . $row["city"] . '","pending","' . $row["user_type"] . '")\' class="dropdown-item" data-bs-toggle="modal" ><i class="mdi mdi-pencil font-size-16 text-primary me-1"></i> Edit</a></li>
                                                                                    <li><a href="#" onclick=\'deletefunc("' . $row["id"] . '","' . $row["id"] . '","pending","'.strtolower($row['user_type']).'")\' class="dropdown-item" data-bs-toggle="modal" ><i class="mdi mdi-trash-can font-size-16 text-danger me-1"></i> Delete</a></li>
                                                                                    <li><a href="#" onclick=\'confirmfunc("' . $row["id"] . '","' . $row["email"] . '","'.$row['user_type'].'")\' class="dropdown-item" data-bs-toggle="modal" ><i class="fas fa-check-circle font-size-16 text-success me-1"></i> Confirm</a></li>
                                                                                </ul>
                                                                            </div>
                                                                        </td>';
                                                                }else if($row['status'] == '4'){
                                                                    echo '<td><span class="badge text-bg-primary">Draft</span></td>
                                                                        <td>
                                                                            <div class="dropdown">
                                                                                <a href="#" class="dropdown-toggle card-drop" data-bs-toggle="dropdown" aria-expanded="false">
                                                                                    <i class="mdi mdi-dots-horizontal font-size-18"></i>
                                                                                </a>
                                                                                <ul class="dropdown-menu">
                                                                                    <li><a href="#" onclick=\'editfuncCust("' . $row["id"] . '","' . $row["reference_no"] . '","' . $row["register_by"] . '","' . $row["country"] . '","' . $row["state"] . '","' . $row["city"] . '","pending","' . $row["user_type"] . '")\' class="dropdown-item" data-bs-toggle="modal" ><i class="mdi mdi-pencil font-size-16 text-primary me-1"></i> Edit</a></li>
                                                                                    <li><a href="#" onclick=\'deletefunc("' . $row["id"] . '","' . $row["id"] . '","pending","'.strtolower($row['user_type']).'")\' class="dropdown-item" data-bs-toggle="modal" ><i class="mdi mdi-trash-can font-size-16 text-danger me-1"></i> Delete</a></li>
                                                                                </ul>
                                                                            </div>
                                                                        </td>';
                                                                }else if($row['upgrade_status_val'] == 1){
                                                                    echo '<td><span class="badge text-bg-info">Upgrade Requested</span></td>
                                                                        <td>
                                                                            <div class="dropdown">
                                                                                <a href="#" class="dropdown-toggle card-drop" data-bs-toggle="dropdown" aria-expanded="false">
                                                                                    <i class="mdi mdi-dots-horizontal font-size-18"></i>
                                                                                </a>
                                                                                <ul class="dropdown-menu">
                                                                                    <li><a href="#" onclick=\'approvalfunc("' . $row["id"] . '","approve","'.$row["upgrade_id"].'")\' class="dropdown-item" data-bs-toggle="modal" ><i class="mdi mdi-check-circle font-size-16 text-success me-1"></i> approve</a></li>
                                                                                    <li><a href="#" onclick=\'approvalfunc("' . $row["id"] . '","reject","'.$row["upgrade_id"].'")\' class="dropdown-item" data-bs-toggle="modal" ><i class="mdi mdi-trash-can font-size-16 text-danger me-1"></i> Reject</a></li>
                                                                                </ul>
                                                                            </div>
                                                                        </td>';
                                                                } else {
                                                                    echo '<td><span class="badge text-bg-danger">Deleted</span></td>
                                                                        <td>
                                                                            <div class="dropdown">
                                                                                <a href="#" class="dropdown-toggle card-drop" data-bs-toggle="dropdown" aria-expanded="false">
                                                                                    <i class="mdi mdi-dots-horizontal font-size-18"></i>
                                                                                </a>
                                                                                <ul class="dropdown-menu">
                                                                                    <li><a href="#" onclick=\'deletefunc("' . $row["id"] . '","' . $row["id"] . '","deleted","'.strtolower($row['user_type']).'")\' class="dropdown-item" data-bs-toggle="modal" ><i class="mdi mdi-file-restore font-size-16 text-success me-1"></i> Restore</a></li>
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

                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row mb-2">
                                            <div class="col-sm-6">
                                                <div class="search-box me-2 mb-2 d-inline-block">
                                                    <div class="position-relative">
                                                        <h4>Registered Institution List</h4>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="row filter-options" id="filterCA">
                                                    <div class="designation-filter no-space col-md-2 col-sm-12">
                                                        <select id="designation" class="selectdesign filter-opt-1 fw-bolder">
                                                            <option value="" selected disabled>--Select Designation--</option>
                                                            <option value="All">All</option>
                                                            <option value="TE">Techno Enterprise</option>
                                                            <option value="F">Franchisee</option>
                                                            <option value="IN">Institution</option>
                                                        </select>
                                                    </div>
                                                    <div class="designation-filter no-space col-md-2 col-sm-12">
                                                        <select id="business_pack" class="selectdesign filter-opt-2 fw-bolder">
                                                            <option value="">--Select Business Packages--</option>
                                                            <!-- <option value="all">All</option> -->
                                                            <option value="200000">Standard</option>
                                                            <option value="300000">Prime</option>
                                                            <option value="500000">Premium</option>
                                                        </select>
                                                    </div>
                                                    <div class="month-filter no-space col-md-2 col-sm-12">
                                                        <div id="cap_text" class="filter-opt-3-1">
                                                            <span  class="span-middle-align">
                                                                <p>Select Month, Year <span class="bx bx-calendar-alt"></span></p> 
                                                            </span>
                                                        </div>
                                                        <input name="date" id="cap_date" class="filter-opt-3 d-none" type="date" placeholder="Select Month, Year">    
                                                    </div>
                                                    <div class="month-filter no-space col-md-2 col-sm-12">
                                                        <div id="cap_text_2" class="filter-opt-3-1">
                                                            <span  class="span-middle-align">
                                                                <p>Select Month, Year <span class="bx bx-calendar-alt"></span></p> 
                                                            </span>
                                                        </div>
                                                        <input name="date" id="month_year_1" class="filter-opt-3 d-none" type="date" placeholder="Select Month, Year">    
                                                    </div>
                                                    <div class="col-md-2 count d-lg-block">
                                                        <div class="position-relative">
                                                            <input type="text" class="count1 text-center" id="caCount" placeholder="Count" readonly>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2 app-search d-lg-block">
                                                        <div class="position-relative">
                                                            <input type="text" class="form-control search control text-center" id="caAmt" placeholder="Amount" readonly>
                                                        </div>
                                                    </div>
                                                    
                                                    <!-- <div class="col-lg-1" id="download_icon" style="display: none;">
                                                        <i class="bx bx-download" onclick="allPayoutExel()" style="font-size: 20px; color: black; margin-left: 40%; cursor: pointer;"></i>
                                                    </div> -->
                                                    
                                                    <!-- <div class="download_payout_exel no-space col-md-1 col-sm-12" style="">
                                                        <i id="download_exel" onclick="allPayoutExel()" style="color: #263238; background: #b6b6b64d; border-radius: 4px; font-size:25px; padding:0; display: none; cursor:pointer;" class="material-icons">play_for_work</i>
                                                    </div> -->
                                                </div> 
                                                <div class="col-sm-2 col-md-2 d-flex justify-content-left align-items-start d-none" id="download_icon">
                                                    <button type="button" onclick="regTcDownload()" class="btn bg-primary text-white mb-3">Download</button>
                                                </div>
                                            </div>
                                            <!-- <div class="col-sm-8">
                                                <div class="text-sm-end">
                                                    <button type="button" data-bs-toggle="modal" data-bs-target="#newCustomerModal" class="btn btn-success btn-rounded waves-effect waves-light mb-2 me-2 addCustomers-modal"><i class="mdi mdi-plus me-1"></i> New Customers</button>
                                                </div>
                                            </div> -->
                                            <!-- end col-->
                                        </div>
                                        
                                        <div class="table-responsive" id="registered_ca">
                                            <table class="table align-middle table-nowrap dt-responsive nowrap w-100" id="registeredCustomerList-table">
                                                <thead class="table-light">
                                                    <tr>
                                                        <th>TE/F/I Id</th>
                                                        <th>Full Name</th>
                                                        <th>Reference ID / Name</th>
                                                        <th>Phone / Email</th>
                                                        <!-- <th>Address</th> -->
                                                        <th>Amount</th>
                                                        <th>Joining Date</th>
                                                        <th>Status</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                        $sql = "
                                                            SELECT 'in' AS user_type, id,  institution_id AS user_id, name, reference_no, registrant, country_code, contact_no, email, amount, register_date, status, register_by, country, state, city,upgrade_status as upgrade_pack 
                                                            FROM  institution 
                                                            WHERE status IN ('1') 
                                                            ORDER BY register_date ASC
                                                        ";

                                                        $stmt = $conn->prepare($sql);
                                                        $stmt->execute();
                                                        $stmt->setFetchMode(PDO::FETCH_ASSOC);

                                                        if ($stmt->rowCount() > 0) {
                                                            foreach ($stmt->fetchAll() as $row) {

                                                                $rd = new DateTime($row['register_date']);
                                                                $rdate = $rd->format('d-m-Y');
                                                                
                                                                
                                                                
                                                                $new_reg= new DateTime('2026-01-01');
                                                                $new_regdate = $new_reg->format('d-m-Y');
                                                                $isNew = ($rd >= $new_reg);
                                                                $color = $isNew ? 'green' : 'black';
                                                                $msg = $isNew ? 'Registered to new regime of terms and conditions' : 'Registered to old regime of terms and conditions';

                                                                echo '<tr>
                                                                        <td class="tooltip-cell" style="color: '.$color .';">
                                                                            '. $row['user_id'].' 
                                                                            <span class="tooltip-msg">'.$msg .'</span>
                                                                        </td>
                                                                        <td> 
                                                                            <span class="badge bg-info lable-width">'
                                                                                . strtoupper($row['user_type'] == 'sf' ? 'f' : ($row['user_type'] == 'te' ? 'te' : ($row['user_type'] == 'in' ? 'in' : ''))) . 
                                                                            '</span>&nbsp;' . $row['name'] ;
                                                                            
                                                                            if($row["upgrade_pack"] == 2){
                                                                                echo '<small class=" d-flex justify-content-center d-block fw-bold text-success px-2 py-1 rounded" style="font-size: 12px; background-color: #e6f4ea;">
                                                                                        Upgraded
                                                                                      </small>';
                                                                            }
                                                                echo'   </td>
                                                                        <td>
                                                                            <p class="mb-1">' . $row['reference_no'] . '</p>
                                                                            <p class="mb-0">' . $row['registrant'] . '</p>
                                                                        </td>
                                                                        <td>
                                                                            <p class="mb-1">+' . $row['country_code'] . ' ' . $row['contact_no'] . '</p>
                                                                            <p class="mb-0">' . $row['email'] . '</p>
                                                                        </td>';
                                                                if($row["upgrade_pack"] == 2){
                                                                    $upgradeTable = $row['user_type'] == 'sf' ? 'sub_franchisee_upgrade' : ($row['user_type'] == 'in' ? 'institution_upgrade' : '');
                                                                    $upgradeTableId = $row['user_type'] == 'sf' ? 'sub_franchisee_id' : ($row['user_type'] == 'in' ? 'institution_id' : '');
                                                                    $sql2 = "SELECT upgrade_amt 
                                                                            FROM $upgradeTable 
                                                                            WHERE $upgradeTableId = :id and upgrade_status=1 ORDER BY id DESC limit 1";

                                                                    $stmt = $conn->prepare($sql2);

                                                                    $stmt->bindParam(':id', $row['user_id'], PDO::PARAM_STR);  // $id must have the value before execute

                                                                    $stmt->execute();

                                                                    $franchisee_upgrade = $stmt->fetch(PDO::FETCH_ASSOC);
                                                                    if ($franchisee_upgrade) {
                                                                        echo '<td>' . $franchisee_upgrade['upgrade_amt'] . '</td>';
                                                                    } else {
                                                                        echo '<td>0</td>'; // or fallback amount
                                                                    } 
                                                                }else{
                                                                    echo'    <td>' . $row['amount'] . '</td>';    
                                                                }
                                                                    echo'    <td>' . $rdate . '</td>';

                                                                if ($row['status'] == '1') {
                                                                    echo '<td><span class="badge text-bg-success">Active</span></td>
                                                                        <td>
                                                                            <div class="dropdown">
                                                                                <a href="#" class="dropdown-toggle card-drop" data-bs-toggle="dropdown" aria-expanded="false">
                                                                                    <i class="mdi mdi-dots-horizontal font-size-18"></i>
                                                                                </a>
                                                                                <ul class="dropdown-menu">
                                                                                    <li><a href="#" onclick=\'overviewPage("' . $row["user_id"] . '","' .$row["reference_no"] . '","' .$row["country"] . '","' .$row["state"] . '","' .$row["city"] . '","' .(strtolower($row['user_type']) == 'sf' ? 'sub_franchisee' : (strtolower($row['user_type']) == 'te' ? 'corporate_agency' :  (strtolower($row['user_type']) == 'in' ? 'institution' : ''))) .'")\' class="dropdown-item" data-bs-toggle="modal"><i class="mdi mdi-eye font-size-16 text-info me-1"></i> View</a></li>';
                                                                                    if($row['user_type'] == 'sf' || $row['user_type'] == 'in'){
                                                                                        echo'<li><a href="#" onclick=\'upgradePage("' . $row["user_id"] . '","' .$row["reference_no"] . '")\'  class="dropdown-item" data-bs-toggle="modal"><i class="mdi mdi-arrow-up-bold text-success me-1"></i> '.($row['user_type'] == 'sf' ? 'Upgrade Franchisee' : ($row['user_type'] == 'in' ? 'Upgrade Institution' : '')) .' </a></li>';
                                                                                    }
                                                                                    
                                                                    echo'           <li><a href="#" onclick=\'editfuncCust("' . $row["user_id"] . '","' . $row["reference_no"] . '","' . $row["register_by"] . '","' . $row["country"] . '","' . $row["state"] . '","' . $row["city"] . '","registered","' . $row["user_type"] . '")\' class="dropdown-item" data-bs-toggle="modal"><i class="mdi mdi-pencil font-size-16 text-primary me-1"></i> Edit</a></li>
                                                                                    <li><a href="#" onclick=\'deletefunc("' . $row["id"] . '","' . $row["user_id"] . '","registered","'.strtolower($row['user_type']).'")\' class="dropdown-item" data-bs-toggle="modal"><i class="mdi mdi-trash-can font-size-16 text-danger me-1"></i> Delete</a></li>
                                                                                </ul>
                                                                            </div>
                                                                        </td>';
                                                                } else {
                                                                    echo '<td><span class="badge text-bg-danger">Deactive</span></td>
                                                                        <td>
                                                                            <div class="dropdown">
                                                                                <a href="#" class="dropdown-toggle card-drop" data-bs-toggle="dropdown" aria-expanded="false">
                                                                                    <i class="mdi mdi-dots-horizontal font-size-18"></i>
                                                                                </a>
                                                                                <ul class="dropdown-menu">
                                                                                    <li><a href="#" onclick=\'deletefunc("' . $row["id"] . '","' . $row["user_id"] . '","deactivate","'.strtolower($row['user_type']).'")\' class="dropdown-item" data-bs-toggle="modal"><i class="mdi mdi-file-restore font-size-16 text-success me-1"></i> Restore</a></li>
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
                                                        <h4>Deleted Institution List</h4>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                        </div>
                                        
                                        <div class="table-responsive" id="deleted_ca">
                                            <table class="table align-middle table-nowrap dt-responsive nowrap w-100" id="deletedCustomerList-table">
                                                <thead class="table-light">
                                                    <tr>
                                                        <th>TE/F/I Id</th>
                                                        <th>Full Name</th>
                                                        <th>Reference ID / Name</th>
                                                        <th>Phone / Email</th>
                                                        <!-- <th>Address</th> -->
                                                        <th>Amount</th>
                                                        <th>Joining Date</th>
                                                        <th>Status</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                        $sql = " 
                                                            SELECT 'in' AS user_type, id, institution_id AS user_id, name, reference_no, registrant, country_code, contact_no, email, amount, register_date, status, register_by, country, state, city 
                                                            FROM institution 
                                                            WHERE status IN ('3')  
                                                            ORDER BY register_date ASC
                                                        ";

                                                        $stmt = $conn->prepare($sql);
                                                        $stmt->execute();
                                                        $stmt->setFetchMode(PDO::FETCH_ASSOC);

                                                        if ($stmt->rowCount() > 0) {
                                                            foreach ($stmt->fetchAll() as $row) {
                                                                

                                                                $rd = new DateTime($row['register_date']);
                                                                $rdate = $rd->format('d-m-Y');
                                                                

                                                                echo '<tr>
                                                                        <td>' . $row['user_id'] . '</td>
                                                                        <td> 
                                                                            <span class="badge bg-info lable-width">'
                                                                                . strtoupper($row['user_type'] == 'sf' ? 'f' : ($row['user_type'] == 'te' ? 'te' : '')) . 
                                                                            '</span>&nbsp;' . $row['name'] ;
                                                                             
                                                                echo'   </td>
                                                                        <td>
                                                                            <p class="mb-1">' . $row['reference_no'] . '</p>
                                                                            <p class="mb-0">' . $row['registrant'] . '</p>
                                                                        </td>
                                                                        <td>
                                                                            <p class="mb-1">+' . $row['country_code'] . ' ' . $row['contact_no'] . '</p>
                                                                            <p class="mb-0">' . $row['email'] . '</p>
                                                                        </td>
                                                                        <td>' . $row['amount'] . '</td>
                                                                        <td>' . $rdate . '</td>';
                                                                echo '  <td><span class="badge text-bg-danger">Deactive</span></td>
                                                                        <td>
                                                                            <div class="dropdown">
                                                                                <a href="#" class="dropdown-toggle card-drop" data-bs-toggle="dropdown" aria-expanded="false">
                                                                                    <i class="mdi mdi-dots-horizontal font-size-18"></i>
                                                                                </a>
                                                                                <ul class="dropdown-menu">
                                                                                    <li><a href="#" onclick=\'deletefunc("' . $row["id"] . '","' . $row["user_id"] . '","deactivate","'.strtolower($row['user_type']).'")\' class="dropdown-item" data-bs-toggle="modal"><i class="mdi mdi-file-restore font-size-16 text-success me-1"></i> Restore</a></li>
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
        <div class="btn" data-bs-toggle="modal" data-bs-target="#institutionModal" style="width: 25px; height: 25px; padding: 0px; position: fixed; bottom: 120px; right: 43px; border-radius: 50%;">
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
        <div class="modal fade" id="institutionModal" tabindex="-1" aria-hidden="true">
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
                            <button type="button" class="btn btn-success" id="add-item"><a href="add_institution.php"><span style="color: white;">Add Now</span></a></button>
                            <button type="button" class="btn btn-secondary" id="close-institutionModal" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end institutionModal -->

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
        <!-- Allocation Modal -->
        <div class="modal fade" id="tcAllotmentModal" tabindex="-1" aria-labelledby="tcAllotmentModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg"> <!-- Use modal-lg for wider layout -->
                <div class="modal-content">
                    
                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h5 class="modal-title" id="tcAllotmentModalLabel">TC Allotment</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    
                    <!-- Modal Body -->
                    <div class="modal-body">
                        <div class="input-block mb-3">
                            <!-- <h4>TC Allotment:</h4> -->
                            
                            <!-- radio in a row -->
                            <div class="d-flex flex-column gap-2 mb-2" id="tcallotment">
                                <label class="form-label fw-bolder">NO. TC Allotment: <span class="text-danger">*</span></label>
                                <div class="d-flex gap-3 flex-wrap">
                                    <div class="form-check me-3">
                                        <input class="form-check-input" type="radio" id="purpose0" name="official_purpose" value="0">
                                        <label class="form-check-label" for="purpose0">0</label>
                                    </div>
                                    <div class="form-check me-3">
                                        <input class="form-check-input" type="radio" id="purpose1" name="official_purpose" value="1">
                                        <label class="form-check-label" for="purpose1">1</label>
                                    </div>
                                    <div class="form-check me-3">
                                        <input class="form-check-input" type="radio" id="purpose2" name="official_purpose" value="2">
                                        <label class="form-check-label" for="purpose2">2</label>
                                    </div>
                                    <div class="form-check me-3">
                                        <input class="form-check-input" type="radio" id="purpose3" name="official_purpose" value="3">
                                        <label class="form-check-label" for="purpose3">3</label>
                                    </div>
                                    <div class="form-check me-3">
                                        <input class="form-check-input" type="radio" id="purpose4" name="official_purpose" value="5">
                                        <label class="form-check-label" for="purpose4">5</label>
                                    </div>
                                    <div class="form-check me-3">
                                        <input class="form-check-input" type="radio" id="purpose5" name="official_purpose" value="7">
                                        <label class="form-check-label" for="purpose5">7</label>
                                    </div>
                                </div>
                            </div>
                            
                            <div id="availableTCs" class="mt-3">
                                <div class="mb-2">
                                    <strong>Selected: <span id="selectedCount">0</span>/<span id="allowedCount">0</span></strong>
                                </div>
                                <div id="tcListContainer" style="max-height: 250px; overflow-y: auto;">
                                    <!-- TC checkboxes will be injected here -->
                                </div>
                                <input type="hidden" name="selected_tc_ids" id="selectedTCsInput">
                            </div>
                        </div>
                    </div>
                    
                    <!-- Modal Footer -->
                    <div class="modal-footer">
                        <input type="hidden" id="hiddenAssign" name="assign_status">
                        <input type="hidden" id="hiddenTcNum" name="tc_num">
                        <input type="hidden" id="hiddenTeid" name="te_id">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" id="AlocTC">Save changes</button>
                    </div>
                    
                </div>
            </div>
        </div>
        <!-- end Allocation Modal -->
        <!-- Allotted TC Details Modal -->
        <div class="modal fade" id="allottedTCModal" tabindex="-1" aria-labelledby="allottedTCModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl"> <!-- Wider for table -->
                <div class="modal-content">

                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h5 class="modal-title" id="allottedTCModalLabel">Allotted TC Details</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <!-- Modal Body -->
                    <div class="modal-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped" id="allottedTCTable">
                                <thead class="table-light">
                                    <tr>
                                        <th>Sr. No</th>
                                        <th>TC Name / ID</th>
                                        <th>TE Name / ID</th>
                                        <th>TE's Ref BM Name /ID</th>
                                        <th>TC's Ref BM Name /ID</th>
                                        <th>Allotment Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Data will be appended dynamically via AJAX -->
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Modal Footer -->
                    <div class="modal-footer">
                        <input type="hidden" id="hiddenAssign1" name="assign_status">
                        <input type="hidden" id="hiddenTcNum1" name="tc_num">
                        <input type="hidden" id="hiddenTeid1" name="te_id">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>

                </div>
            </div>
        </div>
        <!-- Upgrade reject reason -->
        <div class="modal fade" id="rejectModal" tabindex="-1">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Reject Upgrade</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <label>Rejection Reason (max 1000 characters)</label>
                    <textarea id="rejectReason" class="form-control" rows="6" maxlength="1000"
                            placeholder="Enter detailed reason..."></textarea>
                    <small id="charCount">0 / 1000</small>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-danger" id="confirmReject">Reject</button>
                    <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                </div>
                </div>
            </div>
        </div>

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
                window.location.href='edit_corporate_agency.php?vkvbvjfgfikix='+id+'&nohbref='+refno+'&fyfyfregby='+regby+'&ncy='+cut+'&mst='+st+'&hct='+ct+'&editfor='+editfor+'&usertype='+usertype;
            };

            function deletefunc(id,fid,action,usertype){ 
                var dataString = 'id='+id+'&refid='+fid+'&action='+action+'&usertype='+usertype;

                $.ajax({
                type: "POST",
                url: "delete_corporate_agency.php",
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
            //only for frnachisee users
            var rejectId = null;
            var rejectRecId = null;

            function approvalfunc(id, action,rec_id){

                if(action == "reject"){
                    rejectId = id;
                    rejectRecId = rec_id;
                    $("#rejectReason").val("");
                    $("#charCount").text("0 / 1000");
                    $("#rejectModal").modal("show");
                    return;
                }

                sendApproval(id, action, "",rec_id);
            }

            function sendApproval(id, action, reason, rec_id){

                $.ajax({
                    type: "POST",
                    url: "approve_reject_franchisee_upgrade.php",
                    data: {
                        id: id,
                        action: action,
                        reason: reason,
                        rec_id: rec_id
                    },
                    success:function(data){
                        if(data == 1){
                            alert("Upgrade Approved");
                            location.reload();
                        }else if(data == 2){
                            alert("Upgrade Rejected");
                            location.reload();
                        }else{
                            alert("Request Failed !!");
                        }
                    }
                });
            }
            //rejection modal
            $("#rejectReason").on("input", function(){
                $("#charCount").text(this.value.length + " / 1000");
            });

            $("#confirmReject").click(function(){

                var reason = $("#rejectReason").val().trim();

                if(reason == ""){
                    alert("Rejection reason is required!");
                    return;
                }

                sendApproval(rejectId, "reject", reason, rec_id);
                $("#rejectModal").modal("hide");
            });

            function confirmfunc(id,email,usertype){ 

                var dataString = 'id='+ id+'&uname='+email+'&usertype='+usertype;
                $("#loading-overlay").show(); //loading screen
                $.ajax({
                    type: "POST",
                    url: "confirm_corporate_agency.php",
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
                var designation = message=='corporate_agency'?'Techno Enterprise':(message=='sub_franchisee'?'Franchisee':(message == 'institution'?'institution':''));
                window.location.href='../overview_profile/overview.php?id='+id+'&ref='+ref+'&cut='+cut+'&st='+st+'&ct='+ct+'&message='+message+'&designation='+designation;
            }
            //franchisee upgrade
            function upgradePage(id,ref){
                // var designation = message=='corporate_agency'?'Techno Enterprise':(message=='sub_franchisee'?'Franchisee':'');
                window.location.href='upgrade_franchisee.php?id='+id+'&ref='+ref;
            }

            // Hide date label and show input type date 
            var cap_date = document.getElementById("cap_date");
            var cap_text = document.getElementById("cap_text");
            var cap_text_1 = document.getElementById("cap_text_1");
            var cap_text_1 = document.getElementById("cap_text_2");
            var cap_month = document.getElementById("month_year");
            var cap_month = document.getElementById("month_year_1");
            cap_text.addEventListener("click", function(){
                cap_date.classList.replace("d-none","d-block");
                cap_text.classList.add("d-none");
            } );
            cap_text_1.addEventListener("click", function(){
                cap_month.classList.replace("d-none","d-block");
                cap_text_1.classList.add("d-none");
            } );

            $('#filterCA').on('change',function(e){
                e.preventDefault(e);
                $('#download_icon').removeClass('d-none')
                var designation = $('#designation').val()   || "";
                var package = $('#business_pack').val();
                // var converted = $('#converted').prop('checked') ? 1 : "" ;
                // var complimentary = $('#complimentary').prop('checked') ? 1 : "" ;
                var StartFrom = $('#cap_date').val();
                var EndFrom = $('#month_year_1').val();

                // console.log(package);
                // console.log(converted);
                // console.log(complimentary);
                // console.log(StartFrom);
                // console.log(EndFrom);

                // if(package == ''){
                //     alert('Select Business Package First');
                //     window.location.reload();
                // }

                var dataString =  'package='+package+'&StartFrom='+StartFrom+'&EndFrom='+EndFrom+'&designation='+designation;
                // var dataString =  'package='+package+'&converted='+converted+'&complimentary='+complimentary+'&StartFrom='+StartFrom+'&EndFrom='+EndFrom;
                // console.log(dataString);
                $.ajax({
                    type: 'POST',
                    url: 'filter_view_table_ca.php',
                    data: dataString, 
                    cache: false,
                        success: function (data) {

                            console.log('AJAX response:', data); // remove after debug

                            if ($.fn.DataTable.isDataTable('#registeredCustomerList-table')) {
                                $('#registeredCustomerList-table').DataTable().clear().destroy();
                            }

                            $('#registeredCustomerList-table tbody').html(data);

                            $.fn.dataTable.moment('DD-MM-YYYY');

                            // $("#registeredCustomerList-table").DataTable({
                            //     order: [[5, 'asc']]
                            // });

                            let table = $('#registeredCustomerList-table').DataTable();

                            let TotalAmt = 0;
                            let rowCount = table.rows().count();

                            table.rows().every(function () {
                                let amount = parseFloat(this.data()[4]) || 0; // 5th column
                                TotalAmt += amount;
                            });

                            $('#caAmt').val(TotalAmt);
                            $('#caCount').val(rowCount);
                        }


                });

            });

            //for tc allotment
            //on load
            document.addEventListener('DOMContentLoaded', function () {
                var tcAllotmentModal = document.getElementById('tcAllotmentModal');

                tcAllotmentModal.addEventListener('show.bs.modal', function (event) {
                    var button = event.relatedTarget; // The <a> tag that triggered the modal

                    // Get values from data attributes
                    var assignStatus = button.getAttribute('data-bs-assign');
                    var tcNum = button.getAttribute('data-bs-tcnum');
                    var teId = button.getAttribute('data-bs-teid');

                    // Store these values in hidden inputs inside the modal
                    // (Create these hidden inputs in the modal footer or body)
                    document.getElementById('hiddenAssign').value = assignStatus;
                    document.getElementById('hiddenTcNum').value = tcNum;
                    document.getElementById('hiddenTeid').value = teId;

                    // (Optional) Update the UI dynamically if needed
                    document.getElementById('allowedCount').textContent = tcNum; // Show allowed TC count
                });
            });
            let allowedCount = 0;

            // Bind official_purpose change ONCE (outside the checkbox toggle)
            $('input[name="official_purpose"]').on('change', function() {
                allowedCount = parseInt($(this).val());
                $('#allowedCount').text(allowedCount);
                $('#selectedCount').text(0);
                $('#selectedTCsInput').val('');

                // let reference_no = $('#user_id_name').val();

                $.ajax({
                    url: 'get_all_bm_tc.php',
                    type: 'POST',
                    data: {
                        tc_count: allowedCount
                    },
                    success: function(response) {
                        $('#tcListContainer').html(response);
                        $('#availableTCs').removeClass('d-none');

                        // Attach event to checkboxes inside response
                        $('#tcListContainer').on('change', '.tc-checkbox', function() {
                            let selected = $('.tc-checkbox:checked').length;
                            if (selected > allowedCount) {
                                this.checked = false;
                                alert('You can only select ' + allowedCount + ' TC(s).');
                                return;
                            }
                            $('#selectedCount').text(selected);

                            let selectedIds = [];
                            $('.tc-checkbox:checked').each(function() {
                                selectedIds.push($(this).val());
                            });

                            $('#selectedTCsInput').val(selectedIds.join(','));
                        });
                    }
                    
                });
            }); 
            //save changes
            $("#AlocTC").on('click',function(){
                var teid = $("#hiddenTeid").val();
                var tcCount = $('input[name="official_purpose"]:checked').val();
                var selected_count = $('#selectedCount').text();
                let selectedIds = [];
                $('input[name="tc_ids[]"]:checked').each(function () {
                    selectedIds.push($(this).val());
                });
                var data={
                    id:teid,
                    tcCount:tcCount,
                    selectedIds:selectedIds
                }
                console.log(data);
                
                //AJAX request
                $.ajax({
                    url: 'allocate_tcs.php', // Replace with your actual PHP handler
                    type: 'POST',
                    data: JSON.stringify(data),
                    contentType: 'application/json', // Important for JSON
                    dataType: 'json', // Expect JSON response
                    success: function (response) {
                        if (response.status == 'success') {
                            // Success case
                            alert(response.message);
                            $('#tcAllotmentModal').modal('hide');
                            // Optional: refresh table or update UI
                        } else {
                            alert(response.message);
                        }
                    },
                    error: function (xhr, status, error) {
                        console.error('Error:', error);
                        alert('An error occurred. Please try again.');
                    }
                });
            });
            //end
            //show tc allotment
            document.addEventListener('DOMContentLoaded', function () {
                var allottedTCModal = document.getElementById('allottedTCModal');

                allottedTCModal.addEventListener('show.bs.modal', function (event) {
                    var button = event.relatedTarget; // The <a> tag that triggered the modal

                    // Get values from data attributes
                    var assignStatus = button.getAttribute('data-bs-assign');
                    var tcNum = button.getAttribute('data-bs-tcnum');
                    var teId = button.getAttribute('data-bs-teid');

                    // Store these values in hidden inputs inside the modal
                    // (Create these hidden inputs in the modal footer or body)
                    document.getElementById('hiddenAssign1').value = assignStatus;
                    document.getElementById('hiddenTcNum1').value = tcNum;
                    document.getElementById('hiddenTeid1').value = teId;

                    
                });
            });
            function loadAllottedTCs() {
                var teId = $("#hiddenTeid1").val(); // added missing '#' for id selector
                $.ajax({
                    url: 'get_allotted_tcs.php',
                    type: 'POST',
                    contentType: 'application/json', // tell server we send JSON
                    data: JSON.stringify({ te_id: teId }), // convert to JSON string
                    dataType: 'json',
                    success: function(response) {
                        if (response.status === 'success') {
                            let tbody = $('#allottedTCTable tbody');
                            tbody.empty();
                            
                            response.data.forEach((item, index) => {
                                let row = `
                                    <tr>
                                        <td>${index + 1}</td>
                                        <td>${item.travel_agency}</br> ( ${item.tc_id} )</td>
                                        <td>${item.corporate_agency}</br> ( ${item.te_id} )</td>
                                        <td>${item.registrant}</br> ( ${item.reference_no} )</td>
                                        <td>${item.business_mentor}</br> (${item.bm_id})</td>
                                        <td>${item.map_date}</td>
                                    </tr>
                                `;
                                tbody.append(row);
                            });

                            $('#allottedTCModal').modal('show');
                        } else {
                            alert(response.message);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error(error);
                        alert('Failed to fetch allotted TC details.');
                    }
                });
            }


            $('#allottedTCModal').on('shown.bs.modal', function (event) {
                loadAllottedTCs();
            });

            //end 
            //download excel
            function regTcDownload() {
                var packageVal  = $('#business_pack').val() || "";
                var designation = $('#designation').val()   || "";
                var startFrom   = $('#cap_date').val()      || "";
                var endFrom     = $('#month_year_1').val()  || "";

                var params = new URLSearchParams({
                    package: packageVal,
                    StartFrom: startFrom,
                    EndFrom: endFrom,
                    designation: designation
                });

                window.location.href = "download_list.php?" + params.toString();
            }
        </script>

    </body>

</html>
