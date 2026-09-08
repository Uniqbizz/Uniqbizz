<?php
    include_once (__DIR__.'/../dashboard_user_details.php');
?>
<!doctype html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg" data-sidebar-image="none" data-preloader="disable">
    <head>

        <meta charset="utf-8" />
        <title>Recent activities</title>
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
        <!-- custom Css-->
        <link href="../assets/css/custom.min.css" rel="stylesheet" type="text/css" />
        <!-- App Css-->
        <link href="../assets/css/app.min.css" rel="stylesheet" type="text/css" />
        <!-- custom Css developer-->
        <link rel="stylesheet" href="../assets/css/custom.css" />
        <!-- font-awesome -->
        <link rel="stylesheet" href="../assets/fontawesome/css/all.min.css" />
        
        <!-- Customer Dashboard CSS -->
        <link rel="stylesheet" href="../assets/css/travel_consultant.css" />
        <!-- Lists CSS -->
        <link rel="stylesheet" href="../assets/css/lists.css" />
        <!-- FontAwesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <!-- add on 11-06-2026 by SV -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css">
        <!-- add on 11-06-2026 by SV END-->
        <!-- internal style for recent search -->
        <style>
            /* =========================================
            Recent Activity DataTable Search
            ========================================= */

            #recentActivitySearch {
                display: flex;
                align-items: center;
                justify-content: flex-end;
            }

            #recentActivitySearch .dataTables_filter {
                margin: 0;
                padding: 0;
            }

            #recentActivitySearch .dataTables_filter label {
                display: flex;
                align-items: center;
                gap: 8px;
                margin: 0;
                font-weight: 500;
                white-space: nowrap;
            }

            #recentActivitySearch .dataTables_filter input {
                margin: 0 !important;
                width: 220px;
                height: 38px;
                padding: 6px 12px;
                border: 1px solid #dee2e6;
                border-radius: 8px;
                outline: none;
                transition: all 0.2s ease;
            }

            #recentActivitySearch .dataTables_filter input:focus {
                border-color: #4b38b3;
                box-shadow: 0 0 0 0.15rem rgba(75, 56, 179, 0.1);
            }


            /* =========================================
            Tablet
            ========================================= */

            @media (max-width: 768px) {

                #recentActivitySearch .dataTables_filter input {
                    width: 180px;
                }

            }


            /* =========================================
            Mobile
            ========================================= */

            @media (max-width: 576px) {

                #recentActivitySearch {
                    width: 100%;
                    display: block;
                    margin-top: 15px;
                }

                #recentActivitySearch .dataTables_filter {
                    width: 100%;
                }

                #recentActivitySearch .dataTables_filter label {
                    width: 100%;
                    display: flex;
                    align-items: center;
                    gap: 8px;
                }

                #recentActivitySearch .dataTables_filter input {
                    flex: 1;
                    width: 100%;
                    min-width: 0;
                    height: 38px;
                }

            }


            /* =========================================
            Small Mobile
            ========================================= */

            @media (max-width: 400px) {

                #recentActivitySearch {
                    margin-top: 12px;
                }

                #recentActivitySearch .dataTables_filter label {
                    gap: 6px;
                }

                #recentActivitySearch .dataTables_filter input {
                    height: 36px;
                    padding: 5px 10px;
                }

            }
        </style>
        <!-- internal style for recent search -->
    </head>
    <body>
 
        <!-- Begin page -->
        <div id="layout-wrapper">

            <?php 
                    include_once 'travel_consultant_header.php'; 
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
                    include_once 'travel_consultant_sidebar.php'; 
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
                                    <h4 class="mb-sm-0">Recent Activities</h4>
                                    <div class="page-title-right">
                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="travel_consultant_dashboard.php">Dashboard</a></li>
                                            <li class="breadcrumb-item active">Recent Activities</li>
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
                                                <!-- <div class="card-header border-bottom-dashed rounded-top-4 d-flex gap-3">
                                                    <div class="tePendingIcon tePendingIcon1">
                                                        <i class="fa-regular fa-calendar fa-xl"></i> -->
                                                        <!-- <i class="fa-solid fa-hourglass-half fa-xl"></i> -->
                                                    <!-- </div>
                                                    <div class="align-content-end">
                                                        <h5 class="card-title text-dark mb-0">Recent Activity List</h5>
                                                        <p class="text-muted fs-6 mb-0">All recent activity of Tarvel Consultant</p>
                                                    </div>
                                                </div>     -->
                                                <div class="card-header border-bottom-dashed rounded-top-4 d-flex justify-content-between align-items-center">
                                                    <!-- Left: Title -->
                                                    <div class="d-flex gap-3 align-items-center">
                                                        <div class="tePendingIcon tePendingIcon1">
                                                            <i class="fa-regular fa-calendar fa-xl"></i>
                                                        </div>
                                                        <div>
                                                            <h5 class="card-title text-dark mb-0">
                                                                Recent Activity List
                                                            </h5>
                                                            <p class="text-muted fs-6 mb-0">
                                                                All recent activity of Travel Consultant
                                                            </p>
                                                        </div>
                                                    </div>
                                                    <!-- Right: DataTable Search -->
                                                    <div id="recentActivitySearch"></div>
                                                </div>
                                                <div class="card-body">
                                                    <table id="example-dataTable" class="table table-striped table-bordered dt-responsive nowrap align-middle" style="width:100%">
                                                        <thead>
                                                            <tr class="table-primary">
                                                                <th data-ordering="false">Sr.No</th>
                                                                <th data-ordering="false">Type</th>
                                                                <th data-ordering="false">Detials</th>
                                                                <th data-ordering="false">Date</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody id="rcTableBody">
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
                        include_once "travel_consultant_footer.php"; 
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
        <!-- add on 11-06-2026 by SV -->
        <script src="https://cdn.jsdelivr.net/npm/moment/min/moment.min.js"></script>

        <script src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
         <!-- add on 11-06-2026 by SV END-->
        
        <script>
           $(document).ready(function () {

                loadRecentActivitiesTable();

            });


            function loadRecentActivitiesTable() {

                $.ajax({

                    url: 'ajax/recent_activities/recent_activity_data.php',

                    type: 'POST',

                    dataType: 'json',

                    success: function(res) {

                        let html = '';

                        if (res.status && res.data.length > 0) {

                            $.each(res.data, function(index, activity) {

                                let type = '';

                                switch (activity.type) {

                                    case 'pending_customer':
                                        type = 'Pending Customer';
                                        break;

                                    case 'customer_activation':
                                        type = 'Customer Activation';
                                        break;

                                    case 'commission':
                                        type = 'Commission';
                                        break;

                                    case 'booking':
                                        type = 'Booking';
                                        break;

                                    default:
                                        type = 'Activity';
                                }


                                html += `
                                    <tr>

                                        <td>
                                            ${index + 1}
                                        </td>

                                        <td>
                                            ${type}
                                        </td>

                                        <td>
                                            ${activity.title}
                                        </td>

                                        <td data-order="${activity.date}">
                                            ${formatActivityDate(activity.date)}
                                        </td>

                                    </tr>
                                `;

                            });

                        } else {

                            html = `
                                <tr>
                                    <td colspan="4" class="text-center py-4">
                                        No Recent Activities
                                    </td>
                                </tr>
                            `;

                        }


                        // Destroy existing DataTable
                        if ($.fn.DataTable.isDataTable('#example-dataTable')) {

                            $('#example-dataTable')
                                .DataTable()
                                .clear()
                                .destroy();

                        }


                        // Insert rows
                        $('#rcTableBody').html(html);


                        // Initialize DataTable
                        $('#example-dataTable').DataTable({
                            responsive: true,
                            pageLength: 10,
                            lengthChange: true,
                            lengthMenu: [10, 25, 50, 100],
                            searching: true,
                            ordering: true,
                            order: [
                                [3, 'desc']
                            ],
                            columnDefs: [
                                {
                                    orderable: false,
                                    targets: [0, 1, 2]
                                }
                            ]
                        });

                        // Move DataTables search box into card header
                        $('#example-dataTable_filter').appendTo('#recentActivitySearch');

                    },

                    error: function(xhr, status, error) {

                        console.error('Recent Activities Error:', error);

                        console.error(xhr.responseText);

                        $('#rcTableBody').html(`
                            <tr>
                                <td colspan="4" class="text-center py-4 text-danger fw-bold">
                                    Unable to load activities.
                                </td>
                            </tr>
                        `);

                    }

                });

            }
            function formatActivityDate(dateString) {
                if (!dateString) {
                    return '-';
                }

                const date = new Date(dateString.replace(' ', 'T'));

                if (isNaN(date.getTime())) {
                    return dateString;
                }

                const day = String(date.getDate()).padStart(2, '0');

                const month = String(date.getMonth() + 1).padStart(2, '0');

                const year = date.getFullYear();

                let hours = date.getHours();

                const minutes = String(date.getMinutes()).padStart(2, '0');

                const ampm = hours >= 12 ? 'PM' : 'AM';

                hours = hours % 12;

                hours = hours || 12;

                return `${day}-${month}-${year} ${hours}:${minutes} ${ampm}`;
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
        <!-- Sidebar Start -->
        <script>
            document.addEventListener("DOMContentLoaded", function () {

                const sidebar = document.querySelector(".navbar-menu");
                const hamburger = document.getElementById("topnav-hamburger-icon");
                const hamburgerIcon = document.querySelector(".hamburger-icon");
                const overlay = document.querySelector(".vertical-overlay");

                if (window.innerWidth > 1024) {
                    sidebar.classList.remove("sidebar-hidden");
                }

                hamburger.addEventListener("click", function () {

                    if (window.innerWidth <= 1024) {

                        /* BELOW 767 - YOUR ORIGINAL WORKING LOGIC */
                        if (window.innerWidth <= 767) {

                            sidebar.classList.toggle("sidebar-mobile-show");
                            hamburgerIcon.classList.toggle("open");

                            if (overlay) {
                                overlay.classList.toggle("active");
                            }
                        }

                        /* 768px TO 1024px */
                        else {

                            if (!sidebar.classList.contains("sidebar-mobile-show")) {

                                sidebar.classList.add("sidebar-mobile-show");

                                if (overlay) {
                                    overlay.classList.add("active");
                                }

                                /* SHOW 3 LINES */
                                hamburgerIcon.classList.add("open");

                            } else {

                                sidebar.classList.remove("sidebar-mobile-show");

                                if (overlay) {
                                    overlay.classList.remove("active");
                                }

                                /* SHOW ARROW */
                                hamburgerIcon.classList.remove("open");
                            }
                        }

                    } else {

                        /* DESKTOP */
                        sidebar.classList.toggle("sidebar-hidden");
                    }
                });

                if (overlay) {

                    overlay.addEventListener("click", function () {

                        sidebar.classList.remove("sidebar-mobile-show");
                        overlay.classList.remove("active");
                        hamburgerIcon.classList.remove("open");

                    });
                }

            });
        </script>
        <!-- Sidebar End -->
    </body>
</html>