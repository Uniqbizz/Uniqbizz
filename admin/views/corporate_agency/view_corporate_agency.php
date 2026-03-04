<?php
    session_start();

    if(!isset($_SESSION['username'])){
        echo '<script>location.href = "../login.php";</script>';
    }

    require '../../connect.php';
    $date = date('Y'); 
?>
<!doctype html>
<html lang="en">
    
    <head>
        
        <meta charset="utf-8" />
        <title>Techno Enterprise / Franchisee View / Institution | Admin Dashboard </title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!-- App favicon -->
        <link rel="shortcut icon" href="../../assets/images/fav.png">

        <!-- bootstrap-datepicker css -->
        <link href="../../assets/libs/bootstrap-datepicker/css/bootstrap-datepicker.min.css" rel="stylesheet" type="text/css">

        <!-- DataTables -->
        <link href="../../assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />

        <!-- Responsive datatable examples -->
        <link href="../../assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css" />  

        <!-- Bootstrap Css -->
        <link href="../../assets/css/bootstrap.min.css" id="bootstrap-style" rel="stylesheet" type="text/css" />
        <!-- Icons Css -->
        <link href="../../assets/css/icons.min.css" rel="stylesheet" type="text/css" />
        <!-- App Css-->
        <link href="../../assets/css/app.min.css" id="app-style" rel="stylesheet" type="text/css" />
        <!-- Loading Screen and Images size css  -->
        <link href="../../assets/css/loadingScreen.css" rel="stylesheet" type="text/css" />

        <link href="../../assets/css/ca_filter.css" rel="stylesheet" type="text/css" />
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
                include_once '../../header.php';

                // sidebar navigation menu 
                include_once '../../sidebar.php';
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
                                    <h4 class="mb-sm-0 font-size-18">Techno Enterprise / Franchisee / Institution</h4>
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
                                                        <h4>Pending Techno Enterprise / Franchisee / Institution List</h4>
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
                                                    <!-- data load from model folder -->
                                                     <?php include '../../models/corporate_agency/pending_te_f_list.php' ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--end Pending list -->

                        <!-- Registred list -->
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row mb-2">
                                            <div class="col-sm-6">
                                                <div class="search-box me-2 mb-2 d-inline-block">
                                                    <div class="position-relative">
                                                        <h4>Registered Techno Enterprise / Franchisee / Institution List</h4>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="row filter-options" id="filterCA">
                                                    <div class="designation-filter no-space col-md-2 col-sm-12">
                                                        <select id="designation" class="selectdesign filter-opt-1 fw-bolder">
                                                            <!-- <option value="" selected disabled>--Select Designation--</option> -->
                                                            <option value="All" selected>All</option>
                                                            <option value="TE">Techno Enterprise</option>
                                                            <option value="F">Franchisee</option>
                                                            <option value="IN">Institution</option>
                                                        </select>
                                                    </div>
                                                    <div class="designation-filter no-space col-md-2 col-sm-12">
                                                        <select id="business_pack" class="selectdesign filter-opt-2 fw-bolder">
                                                            <option value="">--Select Business Packages--</option>
                                                            <option value="all" selected>All</option>
                                                            <option value="100000">1,00,000</option>
                                                            <option value="200000">2,00,000</option>
                                                            <option value="300000">3,00,000</option>
                                                            <option value="400000">4,00,000</option>
                                                            <option value="500000">5,00,000</option>
                                                            <option value="500000_above">Above 5,00,000</option>
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
                                                </div> 
                                                <div class="col-sm-2 col-md-2 d-flex justify-content-left align-items-start d-none" id="download_icon">
                                                    <button type="button" onclick="regTcDownload()" class="btn bg-primary text-white mb-3">Download</button>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="table-responsive" id="registered_ca">
                                            <table class="table align-middle table-nowrap dt-responsive nowrap w-100" id="registeredCustomerList-table">
                                                <thead class="table-light">
                                                    <tr>
                                                        <th>TE/F/I Id</th>
                                                        <th>Full Name</th>
                                                        <th>Reference ID / Name</th>
                                                        <th>Phone / Email</th>
                                                        <th>Amount</th>
                                                        <th>Joining Date</th>
                                                        <th>Status</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <!-- data load from filter_view_table_ca -->
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
                        <!--end Registred list -->

                        <!--Deleted Users-->
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row mb-2">
                                            <div class="col-sm-6">
                                                <div class="search-box me-2 mb-2 d-inline-block">
                                                    <div class="position-relative">
                                                        <h4>Deleted Techno Enterprise / Franchisee / Institution List</h4>
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
                                                    <!-- data load from model folder -->
                                                    <?php include '../../models/corporate_agency/deleted_te_f_list.php' ?>
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

                
                <?php include_once "../../footer.php" ?>
            </div>
            <!-- end main content-->

        </div>
        <!-- END layout-wrapper -->
        
        <!-- loading screen -->
        <div id="loading-overlay">
            <div class="loading-icon"></div>
        </div>
        <!-- Add button icon -->
        <div class="btn" data-bs-toggle="modal" data-bs-target="#newCorporateAgencyModal" style="width: 25px; height: 25px; padding: 0px; position: fixed; bottom: 120px; right: 43px; border-radius: 50%;">
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
        <div class="modal fade" id="newCorporateAgencyModal" tabindex="-1" aria-hidden="true">
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
                            <button type="button" class="btn btn-success" id="add-item"><a href="add_corporate_agency.php"><span style="color: white;">Add Now</span></a></button>
                            <button type="button" class="btn btn-secondary" id="close-newCorporateAgencyModal" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end newCorporateAgencyModal -->

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
        <script src="../../assets/libs/jquery/jquery.min.js"></script>
        <script src="../../assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
        <script src="../../assets/libs/metismenu/metisMenu.min.js"></script>
        <script src="../../assets/libs/simplebar/simplebar.min.js"></script>
        <script src="../../assets/libs/node-waves/waves.min.js"></script>
        <!-- bootstrap-datepicker js -->
        <script src="../../assets/libs/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>

        <!-- Required datatable js -->
        <script src="../../assets/libs/datatables.net/js/jquery.dataTables.min.js"></script>
        <script src="../../assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>
        
        <!-- Responsive examples -->
        <script src="../../assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
        <script src="../../assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js"></script>
        
        <!-- Moment.js -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment.min.js"></script>

        <!-- DataTables datetime sort plugin -->
        <script src="https://cdn.datatables.net/plug-ins/1.13.6/sorting/datetime-moment.js"></script>
        
        <!-- App js -->
        <script src="../../assets/js/app.js"></script>
        <script src="../../resources/common_resources/top_function.js"></script>
        <script src="../../resources/corporate_agency/te_f_custom.js"></script>
    </body>

</html>
