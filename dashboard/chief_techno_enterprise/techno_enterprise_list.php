<?php
    include_once (__DIR__.'/../dashboard_user_details.php');
?>
<!doctype html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg" data-sidebar-image="none" data-preloader="disable">
    <head>

        <meta charset="utf-8" />
        <title> Techno Enterprise | Franchisee | Institution List </title>
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
        <link rel="stylesheet" href="../assets/css/chief_techno_enterprise.css" />
        <!-- Lists CSS -->
        <link rel="stylesheet" href="../assets/css/lists.css" />
        <!-- FontAwesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <!-- add on 10-06-2026 by SV -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css">
        
        <!-- add on 10-06-2026 by SV END-->
    </head>
    <body>
 
        <!-- Begin page -->
        <div id="layout-wrapper">

            <?php 
                    include_once 'chief_techno_header.php'; 
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
                    include_once 'chief_techno_sidebar.php'; 
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
                                    <h4 class="mb-sm-0">Techno Enterprise | Franchisee | Institution</h4>

                                    <div class="page-title-right">
                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="chief_techno_dashboard.php">Dashboard</a></li>
                                            <li class="breadcrumb-item active">View Techno Enterprise | Franchisee | Institution</li>
                                        </ol>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <!-- end page title -->

                        <div class="row">
                            <div class="col">

                                <div class="h-100">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="card rounded-4 border-1">
                                                <div class="card-header border-bottom-dashed rounded-top-4 d-flex gap-3">
                                                    <div class="tePendingIcon tePendingIcon1">
                                                        <i class="fa-solid fa-hourglass-half fa-xl"></i>
                                                    </div>
                                                    <div class="align-content-end">
                                                        <h5 class="card-title text-dark mb-0">Pending Techno Enterprise | Franchisee | Institution List</h5>
                                                        <p class="text-muted fs-6 mb-0">Techno Enterprise | Franchisee | Institution pending for approval</p>
                                                    </div>
                                                </div>    
                                                <div class="card-body">
                                                    <table id="example-dataTable" class="table table-striped table-bordered dt-responsive nowrap align-middle" style="width:100%">
                                                        <thead>
                                                            <tr class="table-primary">
                                                                <th data-ordering="false">Full Name</th>
                                                                <th data-ordering="false">Reference ID & Name</th>
                                                                <th data-ordering="false">Phone & Email</th>
                                                                <th data-ordering="false">Joining Date</th>
                                                                <th data-ordering="false">Status</th>
                                                                <th data-ordering="false">Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody id="teTableBody">
                                                            
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="card rounded-4 border-1">
                                                <div class="card-header border-bottom-dashed rounded-top-4">
                                                    <div class="row">
                                                        <div class="col-xl-5 col-lg-12 col-md-12 col-sm-12 col-12 mb-2">
                                                            <div class="d-flex gap-3">
                                                                <div class="tePendingIcon tePendingIcon2">
                                                                    <i class="ri-verified-badge-line" style="font-size: 30px;"></i>
                                                                </div>
                                                                <div class="align-content-end">
                                                                    <h5 class="card-title text-dark mb-0">Registered Techno Enterprise | Franchisee | Institution List</h5>
                                                                    <p class="text-muted fs-6 mb-0">All approved and active Techno Enterprises | Franchisee | Institution</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-xl-7 col-lg-12 col-md-12 col-sm-12 col-12 mb-2">
                                                            <div class="d-flex justify-content-end gap-2 teSectionSize">
                                                                <!-- Date Range -->
                                                                <div>
                                                                    <div id="reportrange"
                                                                        class="bg-primary text-white px-3 py-2 text-center dateRange"
                                                                        style="border-radius:6px; cursor:pointer;">
                                                                        <i class="fa fa-calendar"></i>
                                                                        &nbsp;
                                                                        <span id="selectedDate"></span>
                                                                        <i class="fa-solid fa-angle-down"></i>
                                                                    </div>
                                                                </div>
                                                                <div class="countDownloadBtn gap-2">
                                                                    <div class="d-flex gap-2">
                                                                        <p class="fs-6 text-dark mb-1 align-content-center">Count</p>
                                                                        <input type="number" class="dateInput" id="rowCount" readonly>
                                                                    </div>
                                                                    <a href="#" class="text-decoration-none" id="exportte">
                                                                        <div class="stWalletBtn rounded-3 py-2">
                                                                            <i class="fa-solid fa-download me-2"></i>
                                                                            <p class="fs-6 mb-0 fw-bolder pe-1">Download</p>
                                                                        </div>
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="card-body">
                                                    <table id="example-dataTable-2" class="table table-striped table-bordered dt-responsive nowrap table-striped align-middle" style="width:100%">
                                                        <thead>
                                                            <tr class="table-primary">
                                                                <th data-ordering="false">TE | F | I ID & Full Name</th>
                                                                <th data-ordering="false">Reference ID & Name</th>
                                                                <th data-ordering="false">Phone & Email</th>
                                                                <th data-ordering="false">Amt (&#8377;)</th>
                                                                <th data-ordering="false">Joining Date</th>
                                                                <th data-ordering="false">Status</th>
                                                                <th data-ordering="false">Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div> <!-- container-fluid -->

                </div><!-- End Page-content -->
                <?php 
                        include_once "chief_techno_footer.php"; 
                ?>
            </div><!-- end main content-->
        </div><!-- END layout-wrapper -->

        <!--start back-to-top-->
        <button onclick="topFunction()" class="scrollToTop scroll-btn show btn" id="back-to-top">
            <i class="ri-arrow-up-line"></i>
        </button>
        <!--end back-to-top-->
        <!-- contact card pop up  start-->
        <!-- <button type="button" class="contactBtn btn" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
            <i class="ri-phone-fill"></i>
        </button> -->
        <?php include (__DIR__.'/../contact_modal.php') ?>
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
        

        <!-- App js -->
        <script src="../assets/js/app.js"></script>
        <!-- add on 10-06-2026 by SV -->
        <script src="https://cdn.jsdelivr.net/npm/moment/min/moment.min.js"></script>

        <script src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
         <!-- add on 10-06-2026 by SV END-->

        <script>
            const teTable = $('#example-dataTable').DataTable({
                destroy: true,
                responsive: true,
                processing: true,
                searching: true,
                paging: true,
                ordering: false,
                data: [],
                columns: [

                    {
                        data: null,
                        render: function(data){

                            let badge = '';

                            if (data.user_type == 16) {

                                badge = '<span class="badge bg-primary ms-1">TE</span>';

                            } else if (data.user_type == 29) {

                                badge = '<span class="badge bg-success ms-1">F</span>';
                            }

                            return `
                                <p class="fs-6 mb-0">
                                    ${badge} ${data.firstname || ''} ${data.lastname || ''}
                                </p>
                            `;
                        }
                    },

                    {
                        data: null,
                        render: function(data){

                            return `
                                <div>
                                    <p class="fs-6 mb-0">
                                        ${data.ref_firstname || ''} ${data.ref_lastname || ''}
                                    </p>

                                    <p class="fs-6 mb-0">
                                        ${data.super_techno_enterprise_id || '-'}
                                    </p>
                                </div>
                            `;
                        }
                    },

                    {
                        data: null,
                        render: function(data){

                            return `
                                <div>
                                    <p class="fs-6 mb-0">
                                        <i class="fa-solid fa-phone me-2"></i>
                                        ${data.contact_no || '-'}
                                    </p>

                                    <p class="fs-6 mb-0">
                                        <i class="fa-regular fa-envelope me-2"></i>
                                        ${data.email || '-'}
                                    </p>
                                </div>
                            `;
                        }
                    },

                    {
                        data: 'added_on',
                        render: function(data){

                            if(!data) return '-';

                            return `
                                <p class="fs-6 mb-0">
                                    <i class="fa-solid fa-calendar-days me-2"></i>
                                    ${moment(data).format('DD MMM YYYY')}
                                </p>
                            `;
                        }
                    },

                    {
                        data: 'status',
                        render: function(status){

                            if(status == 2){

                                return `
                                    <p class="tePendingBtn rounded-pill text-center mb-0">
                                        Pending
                                    </p>
                                `;
                            }

                            else if(status == 4){

                                return `
                                    <p class="teDraftBtn rounded-pill text-center mb-0">
                                        Draft
                                    </p>
                                `;
                            }
                        }
                    },
                    {
                        data: null,
                        orderable: false,
                        searchable: false,
                        render: function(data) {
                            

                            return `
                                <form action="edit_techno_enterprise.php" method="POST" class="m-0">
                                    <input
                                        type="hidden"
                                        name="id"
                                        value="${data.id}"
                                    >
                                    <input
                                        type="hidden"
                                        name="status"
                                        value="${data.status}"
                                    >
                                    <input
                                        type="hidden"
                                        name="edittype"
                                        value="${data.user_type}"
                                    >

                                    <button
                                        type="submit"
                                        class="border-0 bg-transparent p-0 w-100"
                                    >
                                        <p class="teViewBtn text-center fw-bold mb-0">
                                            <i class="fa-solid fa-eye me-2 mt-1"></i>${data.status == 4 ? 'Edit' : 'View'}
                                        </p>
                                    </button>
                                </form>
                            `;
                        }
                    }
                ],
                language: {
                    emptyTable: "No Pending Techno Enterprise Found"
                }
            });
            function loadPendingTEList(){

                $.ajax({
                    url: 'models/techno_enterprise/ste_pending_te_table_data.php',
                    type: 'POST',
                    dataType: 'json',

                    success: function(res){

                        if(!res.status){

                            teTable.clear().draw();
                            
                            return;
                        }

                        teTable.clear();
                        teTable.rows.add(res.data);
                        teTable.draw();
                        
                    },

                    error: function(){

                        teTable.clear().draw();
                    }
                });

            }
            
            const teRegTable = $('#example-dataTable-2').DataTable({
                responsive: true,
                ordering: false,
                searching: true,
                paging: true,
                data: [],
                columns: [
                    {
                        data: null,
                        render: function(data) {
                            let badge = '';

                            if (data.user_type == 16) {

                                badge = '<span class="badge bg-primary ms-1">TE</span>';

                            } else if (data.user_type == 29) {

                                badge = '<span class="badge bg-success ms-1">F</span>';
                            }
                            return `
                                <p class="fs-6 mb-0">
                                    ${badge} ${data.firstname || ''} ${data.lastname || ''}
                                </p>
                                <p class="fs-6 mb-0">
                                    ${data.teuser_id || ''}
                                </p>
                            `;
                        }
                    },
                    {
                        data: null,
                        render: function(data) {
                            return `
                                <div>
                                    <p class="fs-6 mb-0">
                                        ${data.ref_firstname || '-'} ${data.ref_lastname || ''}
                                    </p>
                                    <p class="fs-6 mb-0">
                                        ${data.super_techno_enterprise_id || '-'}
                                    </p>
                                </div>
                            `;
                        }
                    },
                    {
                        data: null,
                        render: function(data) {
                            return `
                                <div>
                                    <p class="fs-6 mb-0">
                                        <i class="fa-solid fa-phone me-2"></i>
                                        ${data.contact_no || '-'}
                                    </p>
                                    <p class="fs-6 mb-0">
                                        <i class="fa-regular fa-envelope me-2"></i>
                                        ${data.email || '-'}
                                    </p>
                                </div>
                            `;
                        }
                    },
                    {
                        data: 'amount',
                        render: function(data) {

                            if(!data || data == 0) {
                                return '-';
                            }

                            return `
                                <p class="fs-6 mb-0">
                                    ₹ ${Number(data).toLocaleString('en-IN', {
                                        minimumFractionDigits: 2,
                                        maximumFractionDigits: 2
                                    })}
                                </p>
                            `;
                        }
                    },
                    {
                        data: 'register_date',
                        render: function(data) {

                            if(!data) return '-';

                            return `
                                <p class="fs-6 mb-0">
                                    <i class="fa-solid fa-calendar-days me-2"></i>
                                    ${moment(data).format('DD MMM YYYY')}
                                </p>
                            `;
                        }
                    },
                    {
                        data: 'status',
                        render: function(status) {

                            let badge = 'tePendingBtn';
                            let text = 'Pending';

                            if(status == 1){

                                badge = 'teActiveBtn';
                                text = 'Active';

                            }else if(status == 2){

                                badge = 'tePendingBtn';
                                text = 'Inactive';

                            }else{

                                badge = 'teDeletedBtn';
                                text = 'NA';

                            }

                            return `
                                <p class="${badge} rounded-pill text-center mb-0">
                                    ${text}
                                </p>
                            `;
                        }
                    },
                    {
                        data: null,
                        orderable: false,
                        searchable: false,
                        render: function(data) {

                            return `
                                <form action="edit_techno_enterprise.php" method="POST" class="m-0">
                                    
                                    <input
                                        type="hidden"
                                        name="id"
                                        value="${data.teuser_id}"
                                    >
                                    <input
                                        type="hidden"
                                        name="status"
                                        value="${data.status}"
                                    >
                                    <input
                                        type="hidden"
                                        name="edittype"
                                        value="${data.user_type}"
                                    >
                                    <button
                                        type="submit"
                                        class="border-0 bg-transparent p-0 w-100"
                                    >
                                        <p class="teViewBtn text-center fw-bold mb-0">
                                            <i class="fa-solid fa-eye me-2 mt-1"></i>View
                                        </p>
                                    </button>
                                </form>
                            `;
                        }
                    }
                ],
                language: {
                    emptyTable: 'No Techno Enterprise Found'
                }
            });


            function loadRegisteredTEList(){

                $.ajax({

                    url: 'models/techno_enterprise/ste_registered_te_list.php',

                    type: 'POST',

                    dataType: 'json',

                    data: {
                        start_date: window.startDate,
                        end_date: window.endDate
                    },

                    success: function(res){

                        // console.log(res);

                        teRegTable.clear();

                        if(res.status && res.data.length > 0){

                            teRegTable.rows.add(res.data);
                            $('#rowCount').val(res.data.length);

                        }

                        teRegTable.draw();

                    },

                    error: function(xhr){

                        // console.log(xhr.responseText);

                        teRegTable.clear().draw();

                    }

                });

            }


           
            $(function () {

                let start = moment('2020-01-01');
                let end = moment();

                function cb(start, end) {

                    $('#selectedDate').html(
                        start.format('MMMM D, YYYY') +
                        ' - ' +
                        end.format('MMMM D, YYYY')
                    );

                    window.startDate = start.format('YYYY-MM-DD');
                    window.endDate = end.format('YYYY-MM-DD');

                    loadRegisteredTEList();
                }

                $('#reportrange').daterangepicker({
                    startDate: start,
                    endDate: end,

                    showDropdowns: true,
                    alwaysShowCalendars: true,
                    opens: 'left',

                    ranges: {
                        'Today': [
                            moment(),
                            moment()
                        ],
                        'Yesterday': [
                            moment().subtract(1, 'days'),
                            moment().subtract(1, 'days')
                        ],
                        'Last 7 Days': [
                            moment().subtract(6, 'days'),
                            moment()
                        ],
                        'Last 30 Days': [
                            moment().subtract(29, 'days'),
                            moment()
                        ],
                        'This Month': [
                            moment().startOf('month'),
                            moment().endOf('month')
                        ],
                        'Last Month': [
                            moment().subtract(1, 'month').startOf('month'),
                            moment().subtract(1, 'month').endOf('month')
                        ],
                        'Last Year': [
                            moment().subtract(1, 'year').startOf('year'),
                            moment().subtract(1, 'year').endOf('year')
                        ]
                    }
                }, cb);

                cb(start, end);

            });
            $(document).ready(function(){

                loadPendingTEList();
                loadRegisteredTEList();

            });
            $('#exportte').on('click', function(){
                window.location.href =
                'models/common/download_registered_list.php?' +
                'type=te' +
                '&start_date=' + startDate +
                '&end_date=' + endDate;
            });
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