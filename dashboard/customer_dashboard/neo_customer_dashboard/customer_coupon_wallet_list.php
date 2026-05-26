<?php
    include_once (__DIR__ .'/../../dashboard_user_details.php');
    include (__DIR__ .'/../customer_model.php');
    include (__DIR__.'/../urls.php');

?>
<!doctype html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg" data-sidebar-image="none" data-preloader="disable">
    <head>
        <meta charset="utf-8" />
        <title>Dashboard | Uniqbizz</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!-- App favicon -->
        <link rel="shortcut icon" href="<?= $base_url ?>assets/images/fav.png">

        <!-- jsvectormap css -->
        <link href="<?= $base_url ?>assets/libs/jsvectormap/css/jsvectormap.min.css" rel="stylesheet" type="text/css" />

        <!--Swiper slider css-->
        <link href="<?= $base_url ?>assets/libs/swiper/swiper-bundle.min.css" rel="stylesheet" type="text/css" />

        <!-- Layout config Js -->
        <script src="<?= $base_url ?>assets/js/layout.js"></script>
        <!-- Bootstrap Css -->
        <link href="<?= $base_url ?>assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <!-- Icons Css -->
        <link href="<?= $base_url ?>assets/css/icons.min.css" rel="stylesheet" type="text/css" />
        <!-- App Css-->
        <link href="<?= $base_url ?>assets/css/app.min.css" rel="stylesheet" type="text/css" />
        <!-- custom Css-->
        <link href="<?= $base_url ?>assets/css/custom.min.css" rel="stylesheet" type="text/css" />
        <!-- custom Css developer-->
        <link rel="stylesheet" href="<?= $base_url ?>assets/css/custom.css" />
        <!-- Customer Dashboard CSS -->
        <link rel="stylesheet" href="<?= $base_url ?>assets/css/customer_dashboard.css" />

        <!-- FontAwesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <link rel="stylesheet" href="<?= $base_url ?>assets/css/neo_select/customer_coupon_wallet.css" />
        <link rel="stylesheet" href="https://cdn.datatables.net/1.13.8/css/jquery.dataTables.min.css">
    </head>

    <body class="twocolumn-panel">
        <!-- Begin page -->
        <div id="layout-wrapper">
            <?php include_once(__DIR__ . '/../customer_header.php'); ?>

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

            <?php include_once (__DIR__ . '/../customer_sidebar.php') ?>
            <!-- ============================================================== -->
            <!-- Start of Customer Dashboard here -->
            <!-- ============================================================== -->
            <div class="main-content">
                <div class="page-content">
                    <div class="container-fluid ps-0">
                        <div class="coupon-page">

                            <!-- TITLE -->

                            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">

                                <div>
                                    <h1 class="coupon-title">My Coupons</h1>
                                    <div class="coupon-subtitle">
                                        Use your coupons to save more on your next trip.
                                    </div>
                                </div>

                                
                                <button class="btn help-btn">
                                    <i class="fa-regular fa-circle-play me-2"></i>
                                    How to Use Coupons
                                </button>
                                

                            </div>

                            <!-- SUMMARY -->

                            <div class="summary-card">

                                <div class="summary-top">

                                    <div class="row align-items-center g-4">

                                        <div class="col-lg-3">

                                            <div class="coupon-ticket">

                                                <div class="ticket-count"><?= $couponData['coupon_total'] ?></div>

                                                <div class="ticket-label">
                                                    COUPONS
                                                </div>

                                            </div>

                                        </div>

                                        <div class="col-lg-9">

                                            <div class="row">

                                                <div class="col-md-3 summary-stat">

                                                    <div class="stat-label">
                                                        Total Coupons
                                                    </div>

                                                    <div class="stat-value">
                                                        <?= $couponData['coupon_total'] ?>
                                                    </div>

                                                </div>

                                                <div class="col-md-3 summary-stat">

                                                    <div class="stat-label">
                                                        Used Coupons
                                                    </div>

                                                    <div class="stat-value">
                                                        <?= $couponData['used_coupon_total'] ?>
                                                    </div>

                                                </div>

                                                <div class="col-md-3 summary-stat">

                                                    <div class="stat-label">
                                                        Available Coupons
                                                    </div>

                                                    <div class="stat-value green">
                                                        <?= $couponData['active_coupon_total'] ?>
                                                    </div>

                                                </div>

                                                <div class="col-md-3 summary-stat">

                                                    <div class="stat-label">
                                                        Total Value
                                                    </div>

                                                    <div class="stat-value purple">
                                                        ₹<?= $couponData['coupon_total_value'] ?>
                                                    </div>

                                                </div>

                                            </div>

                                        </div>

                                    </div>

                                </div>

                                <!-- FEATURE STRIP -->

                                <div class="feature-strip">

                                    <div class="row text-center g-3">

                                        <div class="col-md-4">
                                            <div class="feature-item">
                                                <i class="fa-solid fa-ticket"></i>
                                                1 Coupon = ₹500
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="feature-item">
                                                <i class="fa-regular fa-user"></i>
                                                1 Coupon per passenger per booking
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="feature-item">
                                                <i class="fa-solid fa-ban"></i>
                                                Cannot be encashed or transferred
                                            </div>
                                        </div>

                                    </div>

                                </div>

                            </div>

                            <!-- TABLE CARD -->

                            <div class="coupon-tabs">

                                <!-- TABS -->

                                <!-- =========================
                                COUPON TABLE TABS
                                ========================= -->

                                <div class="tabs-wrapper">

                                    <div class="coupon-tabs-nav mb-2">

                                        <button class="coupon-tab active" data-filter="all">
                                            <span class="tab-title">All Coupons</span>
                                            <span class="tab-count">30</span>
                                        </button>

                                        <button class="coupon-tab available-tab" data-filter="available">
                                            <span class="tab-title">Available</span>
                                            <span class="tab-count">18</span>
                                        </button>

                                        <button class="coupon-tab used-tab" data-filter="used">
                                            <span class="tab-title">Used</span>
                                            <span class="tab-count">12</span>
                                        </button>

                                        <!--<button class="coupon-tab expired-tab" data-filter="expired">-->
                                        <!--    <span class="tab-title">Expired</span>-->
                                        <!--    <span class="tab-count">3</span>-->
                                        <!--</button>-->

                                    </div>

                                </div>

                                <!-- =========================
                                TABLE
                                ========================= -->

                                <div class="table-responsive">

                                    <table class="coupon-table" id="couponTable">

                                        <thead>

                                            <tr>
                                                <th>Coupon Code</th>
                                                <th>Value</th>
                                                <th>Status</th>
                                                <th>Credited On</th>
                                                <th>Applicable/Applied On</th>
                                                <th>Used On</th>
                                            </tr>

                                        </thead>

                                        <tbody id="couponTableBody">                                          
                                            
                                        </tbody>

                                    </table>

                                </div>
                                <!-- PAGINATION -->
                                <div class="d-flex justify-content-between align-items-center mt-3 flex-wrap gap-2">
                                
                                    <div class="text-muted">
                                        Showing
                                        <span id="showingCount">1</span>
                                        to
                                        <span id="showingEnd">5</span>
                                        of
                                        <span id="totalCoupons">0</span>
                                    </div>
                                
                                    <div class="d-flex gap-2 align-items-center">
                                
                                        <button id="prevPage"
                                            class="btn btn-sm btn-outline-primary">
                                            Previous
                                        </button>
                                
                                        <span id="pageNumbers"
                                            class="d-flex gap-1">
                                        </span>
                                
                                        <button id="nextPage"
                                            class="btn btn-sm btn-outline-primary">
                                            Next
                                        </button>
                                
                                    </div>
                                
                                </div>
                            </div>

                            <!-- IMPORTANT -->

                            <div class="important-box">

                                <div class="important-title">
                                    Important Information
                                </div>

                                <div class="row g-4">

                                    <div class="col-lg-4">

                                        <div class="important-item">

                                            <i class="fa-solid fa-ticket"></i>

                                            <div>
                                                Coupons are applicable on Holiday Packages, Weekend Escapes & Events only.
                                            </div>

                                        </div>

                                    </div>

                                    <div class="col-lg-4">

                                        <div class="important-item">

                                            <i class="fa-regular fa-calendar-check"></i>

                                            <div>
                                                Coupons must be applied at the time of booking confirmation.
                                            </div>

                                        </div>

                                    </div>

                                    <div class="col-lg-4">

                                        <div class="important-item">

                                            <i class="fa-solid fa-ban"></i>

                                            <div>
                                                Used coupons cannot be reactivated or used again.
                                            </div>

                                        </div>

                                    </div>

                                </div>

                            </div>

                        </div>
                    </div>
                </div>
                <?php include_once (__DIR__ . '/../customer_footer.php') ?>
            </div>

            <!-- end main content-->
            <!-- End of Customer Dashboard here -->
            <!-- ============================================================== -->
        </div>
        <!--start back-to-top-->
        <button onclick="topFunction()" class="scrollToTop scroll-btn show btn" id="back-to-top">
            <i class="ri-arrow-up-line"></i>
        </button>
        <!--end back-to-top-->
        <!-- contact card pop up  start-->
        <button type="button" class="contactBtn btn" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
            <i class="ri-phone-fill"></i>
        </button>
        <?php include (__DIR__ .'/../../contact_modal.php') ?>

        <!-- contact card pop up end-->

        <!-- JAVASCRIPT -->
        <script src="<?= $base_url ?>assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
        <script src="<?= $base_url ?>assets/libs/simplebar/simplebar.min.js"></script>
        <script src="<?= $base_url ?>assets/libs/node-waves/waves.min.js"></script>
        <script src="<?= $base_url ?>assets/libs/feather-icons/feather.min.js"></script>
        <script src="<?= $base_url ?>assets/js/jquery/jquery-3.7.1.min.js"></script>

        <!-- !-- materialdesign remix icon js- -->
        <script src="<?= $base_url ?>assets/js/pages/remix-icons-listing.js"></script>

        <!-- Vector map-->
        <script src="<?= $base_url ?>assets/libs/jsvectormap/js/jsvectormap.min.js"></script>
        <script src="<?= $base_url ?>assets/libs/jsvectormap/maps/world-merc.js"></script>

        <!--Swiper slider js-->
        <script src="<?= $base_url ?>assets/libs/swiper/swiper-bundle.min.js"></script>

        <!-- App js -->
        <script src="<?= $base_url ?>assets/js/app.js"></script>

        <script src="<?= $base_url ?>assets/libs/chart.js/Chart-2.5.0.min.js"></script>


        <!-- Dashboard init  popular candidates section js file-->

        <script src="<?= $base_url ?>assets/js/js-confetti.js"></script>
        <script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>

        
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

        <script>
            document.addEventListener("DOMContentLoaded", function () {

                const tableBody =
                    document.getElementById('couponTableBody');

                const tabs =
                    document.querySelectorAll('.coupon-tab');

                const prevBtn =
                    document.getElementById('prevPage');

                const nextBtn =
                    document.getElementById('nextPage');

                const pageNumbers =
                    document.getElementById('pageNumbers');

                const showingCount =
                    document.getElementById('showingCount');

                const showingEnd =
                    document.getElementById('showingEnd');

                const totalCoupons =
                    document.getElementById('totalCoupons');

                let allCoupons = [];
                let filteredCoupons = [];

                let currentPage = 1;

                const rowsPerPage = 10;

                let currentFilter = 'all';

                // =========================
                // FETCH AJAX DATA
                // =========================

                fetch('<?= $base_url_cust ?>ajax/coupon_table_list.php')

                .then(response => response.text())

                .then(data => {

                    console.log(data);

                    try {

                        const result = JSON.parse(data);

                        allCoupons = result.data;

                        updateTabCounts();

                        applyFilter('all');

                    }
                    catch(error){

                        console.error(
                            "Invalid JSON:",
                            error
                        );
                    }
                });

                // =========================
                // RENDER TABLE
                // =========================

                function renderTable() {

                    tableBody.innerHTML = '';

                    const start =
                        (currentPage - 1) * rowsPerPage;

                    const end =
                        start + rowsPerPage;

                    const pageData =
                        filteredCoupons.slice(start, end);

                    pageData.forEach(coupon => {

                        const statusLower =
                            coupon.status.toLowerCase();

                        let applicableHtml = '';

                        // =========================
                        // AVAILABLE COUPONS
                        // =========================

                        if (statusLower === 'available') {

                            applicableHtml = `
                                <div class="applicable-item">
                                    <i class="fa-solid fa-gift"></i>
                                    Holiday Packages
                                </div>

                                <div class="applicable-item">
                                    <i class="fa-solid fa-mountain"></i>
                                    Weekend Escapes
                                </div>

                                <div class="applicable-item">
                                    <i class="fa-solid fa-plane"></i>
                                    Flights
                                </div>

                                <div class="applicable-item">
                                    <i class="fa-solid fa-hotel"></i>
                                    Hotel
                                </div>
                            `;

                        } else {

                            // =========================
                            // USED COUPONS
                            // =========================

                            applicableHtml = `
                                <div class="applicable-item">
                                    <i class="fa-solid fa-umbrella-beach"></i>
                                    ${coupon.used_on ?? 'Booking'}
                                </div>

                                <small class="text-muted">
                                    Booking ID:
                                    ${coupon.booking_id ?? '-'}
                                </small>
                            `;
                        }

                        const row = `
                            <tr data-status="${statusLower}">

                                <td>
                                    <div class="coupon-box">
                                        ${coupon.code}
                                        <div>
                                            ₹${coupon.coupon_amt}
                                        </div>
                                    </div>
                                </td>

                                <td class="coupon-price">
                                    ₹${coupon.coupon_amt}
                                </td>

                                <td>
                                    <span class="
                                        status-badge
                                        ${statusLower === 'available'
                                            ? 'status-available'
                                            : 'status-used'}
                                    ">
                                        ${coupon.status}
                                    </span>
                                </td>

                                <td>
                                    ${coupon.created_date}
                                </td>

                                <td>
                                    ${applicableHtml}
                                </td>

                                <td class="
                                    ${statusLower === 'available'
                                        ? 'text-muted'
                                        : ''}
                                ">
                                    ${statusLower === 'available'
                                        ? '—'
                                        : coupon.used_date}
                                </td>

                            </tr>
                        `;

                        tableBody.insertAdjacentHTML(
                            'beforeend',
                            row
                        );

                    });

                    updatePagination();
                }

                // =========================
                // FILTER
                // =========================

                function applyFilter(filter) {

                    currentFilter = filter;

                    currentPage = 1;

                    if (filter === 'all') {

                        filteredCoupons = [...allCoupons];

                    } else {

                        filteredCoupons =
                            allCoupons.filter(coupon =>
                                coupon.status.toLowerCase() === filter
                            );
                    }

                    renderTable();
                }

                // =========================
                // PAGINATION
                // =========================

                function updatePagination() {

                    const totalPages =
                        Math.ceil(
                            filteredCoupons.length / rowsPerPage
                        );

                    pageNumbers.innerHTML = '';

                    for (let i = 1; i <= totalPages; i++) {

                        const btn =
                            document.createElement('button');

                        btn.textContent = i;

                        btn.className =
                            i === currentPage
                            ? 'btn btn-sm btn-primary'
                            : 'btn btn-sm btn-outline-primary';

                        btn.addEventListener('click', function () {

                            currentPage = i;

                            renderTable();
                        });

                        pageNumbers.appendChild(btn);
                    }

                    prevBtn.disabled =
                        currentPage === 1;

                    nextBtn.disabled =
                        currentPage === totalPages;

                    const startNum =
                        filteredCoupons.length === 0
                        ? 0
                        : ((currentPage - 1)
                            * rowsPerPage) + 1;

                    const endNum =
                        Math.min(
                            currentPage * rowsPerPage,
                            filteredCoupons.length
                        );

                    showingCount.textContent =
                        startNum;

                    showingEnd.textContent =
                        endNum;

                    totalCoupons.textContent =
                        filteredCoupons.length;
                }

                // =========================
                // TAB COUNTS
                // =========================

                function updateTabCounts() {

                    const allCount =
                        allCoupons.length;

                    const availableCount =
                        allCoupons.filter(c =>
                            c.status.toLowerCase() === 'available'
                        ).length;

                    const usedCount =
                        allCoupons.filter(c =>
                            c.status.toLowerCase() === 'used'
                        ).length;

                    document.querySelector(
                        '[data-filter="all"] .tab-count'
                    ).textContent = allCount;

                    document.querySelector(
                        '[data-filter="available"] .tab-count'
                    ).textContent = availableCount;

                    document.querySelector(
                        '[data-filter="used"] .tab-count'
                    ).textContent = usedCount;
                }

                // =========================
                // TAB EVENTS
                // =========================

                tabs.forEach(tab => {

                    tab.addEventListener('click', function () {

                        tabs.forEach(btn => {
                            btn.classList.remove('active');
                        });

                        this.classList.add('active');

                        applyFilter(
                            this.dataset.filter
                        );
                    });

                });

                // =========================
                // PREV BUTTON
                // =========================

                prevBtn.addEventListener('click', function () {

                    if (currentPage > 1) {

                        currentPage--;

                        renderTable();
                    }
                });

                // =========================
                // NEXT BUTTON
                // =========================

                nextBtn.addEventListener('click', function () {

                    const totalPages =
                        Math.ceil(
                            filteredCoupons.length / rowsPerPage
                        );

                    if (currentPage < totalPages) {

                        currentPage++;

                        renderTable();
                    }
                });

            });
        </script>
    </body>
</html>