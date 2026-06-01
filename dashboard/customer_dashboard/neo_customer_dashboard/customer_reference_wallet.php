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
        <link rel="stylesheet" href="<?= $base_url ?>assets/css/neo_select/customer_reference_wallet.css" />
        <link rel="stylesheet" href="<?= $base_url ?>assets/css/neo_select/customer_reference_modal.css" />
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
                        <!-- customer reference wallet -->
                        <section class="wallet-wrapper">

                            <!-- PAGE TITLE -->
                            <div class="wallet-topbar">
                                <div>
                                <h2><i class="fa-solid fa-users"></i> Referral Customer Wallet</h2>
                                <p>View all transactions and earnings from your referred customers.</p>
                                </div>

                                <button class="benefit-btn" id="openReferralModal">
                                <i class="fa-regular fa-circle-question"></i>
                                How Referral Benefits Work?
                                </button>
                            </div>


                            <!-- STATS CARDS -->
                            <div class="stats-grid">

                                <div class="stats-card orange">
                                <div class="stats-icon">
                                    <i class="fa-solid fa-hand-holding-dollar"></i>
                                </div>

                                <div>
                                    <h4>Total Earnings</h4>
                                    <h2>₹<?= (($refWalletData['ref_total_earning'] ?? 0) + ($refWalletCurBalData['ref_booking_total'] ?? 0)) ?></h2>
                                </div>

                                <!--<div class="card-footer-data">-->
                                <!--    <div>-->
                                <!--    <span>This Year</span>-->
                                <!--    <strong>₹3,400</strong>-->
                                <!--    </div>-->

                                <!--    <div>-->
                                <!--    <span>Last Year</span>-->
                                <!--    <strong>₹700</strong>-->
                                <!--    </div>-->
                                <!--</div>-->
                                </div>


                                <div class="stats-card green">
                                <div class="stats-icon">
                                    <i class="fa-solid fa-arrow-trend-up"></i>
                                </div>

                                <div>
                                    <h4>Available Balance</h4>
                                    <h2>₹<?= $refWalletCurBalData['balance'] ?? 0?></h2>
                                </div>

                                <!--<div class="card-footer-data">-->
                                <!--    <div>-->
                                <!--    <span>Withdrawable</span>-->
                                <!--    <strong>₹1,800</strong>-->
                                <!--    </div>-->

                                <!--    <div>-->
                                <!--    <span>On Hold</span>-->
                                <!--    <strong>₹500</strong>-->
                                <!--    </div>-->
                                <!--</div>-->
                                </div>


                                <div class="stats-card blue">
                                <div class="stats-icon">
                                    <i class="fa-solid fa-gift"></i>
                                </div>

                                <div>
                                    <h4>Total Referrals</h4>
                                    <h2><?= $refWalletData['ref_count'] ?? 0 ?></h2>
                                </div>

                                <!--<div class="card-footer-data">-->
                                <!--    <div>-->
                                <!--    <span>Active Referrals</span>-->
                                <!--    <strong>6</strong>-->
                                <!--    </div>-->

                                <!--    <div>-->
                                <!--    <span>Completed Trips</span>-->
                                <!--    <strong>10</strong>-->
                                <!--    </div>-->
                                <!--</div>-->
                                </div>


                                <div class="stats-card purple">
                                <div class="stats-icon">
                                    <i class="fa-solid fa-wallet"></i>
                                </div>

                                <div>
                                    <h4>Total Withdrawn</h4>
                                    <h2>₹<?= $refWalletEncashData['total_earning_echased'] ?? 0 ?></h2>
                                </div>

                                <!--<div class="card-footer-data">-->
                                <!--    <div>-->
                                <!--    <span>This Year</span>-->
                                <!--    <strong>₹1,300</strong>-->
                                <!--    </div>-->

                                <!--    <div>-->
                                <!--    <span>Last Year</span>-->
                                <!--    <strong>₹500</strong>-->
                                <!--    </div>-->
                                <!--</div>-->
                                </div>

                            </div>


                            <!-- INFO STRIP -->
                            <div class="info-strip">
                                <div><i class="fa-solid fa-coins"></i> Earn ₹1,000 on successful membership activation by your referral</div>
                                <div><i class="fa-solid fa-plane-departure"></i> Earn additional benefits on trip completion</div>
                                <div><i class="fa-solid fa-circle-check"></i> Benefits applicable on all travel services</div>
                            </div>


                            <!-- FILTER SECTION -->
                            <!-- search -->
                            <div class="card-header bg-white border-0 p-2">

                                <div class="row align-items-center">

                                    <div class="col-lg-4">
                                        <h5 class="mb-1">Referral Customer Wallet Management</h5>
                                        <small class="text-muted">
                                            Search and manage referral customer entries
                                        </small>
                                    </div>

                                    <div class="col-lg-8 text-lg-end mt-3 mt-lg-0">

                                        <div class="ref-wallet-search ms-lg-auto">
                                            <i class="fa-solid fa-magnifying-glass "></i>

                                            <input type="text" id="tableSearch"
                                                placeholder="Search anything...">

                                            <span type="button" id="clearSearch">
                                                <i class="fa-solid fa-xmark"></i>
                                            </span>
                                        </div>

                                    </div>

                                </div>

                            </div>
                            <!-- FILTER BOX -->
                            <div class="filter-box">

                                <div class="row g-4 align-items-end">

                                    <!-- TRANSACTION TYPE -->

                                    <div class="col-lg-3 col-md-6">

                                        <div class="input-group-custom">

                                            <label>
                                                Transaction Type
                                            </label>

                                            <select
                                                class="form-select"
                                                id="transactionFilter"
                                            >

                                                <option value="all">All</option>

                                                <option value="membership activation bonus">
                                                    Holiday Account Activation
                                                </option>

                                                <option value="trip completed bonus">
                                                    Trip Completed 
                                                </option>

                                                <option value="withdrawal request">
                                                    Withdrawal Request
                                                </option>

                                                <option value="pending clearance">
                                                    Pending Clearance
                                                </option>

                                            </select>

                                        </div>

                                    </div>

                                    <!-- STATUS -->

                                    <div class="col-lg-3 col-md-6">

                                        <div class="input-group-custom">

                                            <label>
                                                Status
                                            </label>

                                            <select
                                                class="form-select"
                                                id="statusFilter"
                                            >

                                                <option value="all">All</option>

                                                <option value="credited">
                                                    Credited
                                                </option>

                                                <option value="pending">
                                                    Pending
                                                </option>

                                                <option value="processed">
                                                    Processed
                                                </option>

                                                <option value="cancelled">
                                                    Cancelled
                                                </option>

                                                <option value="rejected">
                                                    Rejected
                                                </option>

                                            </select>

                                        </div>

                                    </div>

                                    <!-- DATE -->

                                    <div class="col-lg-3 col-md-6">

                                        <div class="input-group-custom">

                                            <label>
                                                Date
                                            </label>

                                            <input
                                                type="date"
                                                class="form-control"
                                                id="dateFilter"
                                            >

                                        </div>

                                    </div>

                                    <!-- DOWNLOAD -->

                                    <div class="col-lg-3 col-md-6">

                                        <div class="download-area">

                                            <button
                                                class="download-btn w-100"
                                                id="downloadBtn"
                                            >

                                                <i class="fa-solid fa-download me-2"></i>

                                                Download Statement

                                            </button>

                                        </div>

                                    </div>

                                </div>

                            </div>


                            <!-- TRANSACTION TABLE -->
                            <!-- ========================= -->
                            <!-- TABLE CONTAINER -->
                            <!-- ========================= -->

                            <div class="table-container">

                                <!-- TITLE -->

                                <div class="table-title d-flex justify-content-between align-items-center mb-4">

                                    <h3 class="mb-0">
                                        All Transactions (<span id="totalTransactions">0</span>)
                                    </h3>

                                </div>

                                <!-- TABLE -->

                                <div class="table-responsive">

                                    <table class="wallet-table table align-middle transaction-table" id="transactionTable">

                                        <thead>

                                            <tr>

                                                <th>Date & Time</th>
                                                <th>Description</th>
                                                <th>Referred Customer</th>
                                                <th>Trip Details</th>
                                                <th>Pax</th>
                                                <th>Per Pax Benefit</th>
                                                <th>Amount</th>
                                                <th>Status</th>
                                                <!--<th>Balance</th>-->
                                                <th>Action</th>

                                            </tr>

                                        </thead>

                                        <tbody id="transactionTableBody">

                                            

                                        </tbody>

                                    </table>

                                </div>

                            </div>


                            <!-- NOTE -->
                            <div class="note-box">
                                <i class="fa-solid fa-circle-info"></i>
                                Referral benefits are credited after successful membership activation or trip completion by your referred customer. Withdrawals are subject to verification and company policy.
                            </div>


                            <!-- HOW YOU EARN -->
                            <div class="earn-grid">

                                <div class="earn-card">
                                <div class="earn-icon orange-bg">
                                    <i class="fa-solid fa-user-plus"></i>
                                </div>

                                <div>
                                    <h4>₹1,000 on Membership Activation</h4>
                                    <p>When your referred customer joins Neo Select Membership successfully.</p>
                                </div>
                                </div>


                                <div class="earn-card">
                                <div class="earn-icon blue-bg">
                                    <i class="fa-solid fa-plane"></i>
                                </div>

                                <div>
                                    <h4>Earn on Trip Completion</h4>
                                    <p>Earn commission for each passenger when your referred customer completes a trip.</p>
                                </div>
                            </div>


                            <div class="earn-card">
                            <div class="earn-icon green-bg">
                                <i class="fa-solid fa-repeat"></i>
                            </div>

                            <div>
                                <h4>More Benefits on Repeated Bookings</h4>
                                <p>Earn additional benefits when your referred customer travels repeatedly.</p>
                            </div>
                            </div>

                        </div>

                        </section>

                        
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
        <?= include 'customer_reference_modal.php' ?>
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

        <script src="<?= $base_url ?>assets/js/js-confetti.js"></script>
        
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

        <!-- dialer logic -->

        <!-- table tabs -->
        <script>

            document.addEventListener("DOMContentLoaded", function () {

                const tableBody =
                    document.getElementById(
                        "transactionTableBody"
                    );

                const totalTransactions =
                    document.getElementById(
                        "totalTransactions"
                    );

                const transactionFilter =
                    document.getElementById(
                        "transactionFilter"
                    );

                const statusFilter =
                    document.getElementById(
                        "statusFilter"
                    );

                const dateFilter =
                    document.getElementById(
                        "dateFilter"
                    );

                let allRows = [];

                // =========================
                // FETCH DATA
                // =========================

                fetch(
                    "<?= $base_url_cust ?>ajax/reference_wallet_history.php"
                )

                .then(response => response.json())

                .then(res => {

                    if (!res.status) {
                        return;
                    }

                    let html = '';

                    res.data.forEach((row, index) => {

                        const detailId =
                            'details-' + index;

                        const statusLower =
                            (
                                row.status || ''
                            ).toLowerCase();

                        const transactionLower =
                            (
                                row.entry_type || ''
                            ).toLowerCase();

                        const amount =
                            parseFloat(
                                row.amount.replace(/,/g,'')
                            );

                        const amountHtml =
                            amount >= 0
                            ?
                            `<span class="text-success fw-bold">
                                +₹${row.amount}
                            </span>`
                            :
                            `<span class="text-danger fw-bold">
                                ₹${row.amount}
                            </span>`;

                        let badgeClass =
                            'bg-secondary';

                        if (
                            statusLower === 'credited'
                        ) {
                            badgeClass = 'bg-success';
                        }

                        if (
                            statusLower === 'processed'
                        ) {
                            badgeClass = 'bg-info';
                        }

                        if (
                            statusLower === 'pending'
                        ) {
                            badgeClass = 'bg-warning';
                        }

                        if (
                            statusLower === 'cancelled'
                            ||
                            statusLower === 'rejected'
                        ) {
                            badgeClass = 'bg-danger';
                        }

                        const paxCount =
                            row.members &&
                            row.members.length > 0
                            ? row.members.length
                            : '-';

                        const perPaxBenefit =
                            paxCount !== '-'
                            ?
                            (
                                amount / paxCount
                            ).toFixed(2)
                            :
                            '-';

                        let memberRows = '';

                        if (
                            row.members &&
                            row.members.length > 0
                        ) {

                            row.members.forEach(member => {

                                memberRows += `
                                    <tr>
                                        <td>${member.name}</td>
                                        <td>${member.age}</td>
                                        <td>${member.gender}</td>
                                    </tr>
                                `;
                            });

                            memberRows += `
                                <tr>
                                    <td colspan="2">
                                        Total Amount Earned
                                    </td>

                                    <td>
                                        ₹${row.amount}
                                    </td>
                                </tr>
                            `;
                        }

                        // =========================
                        // ONLY TRIP COMPLETED BONUS
                        // SHOULD EXPAND
                        // =========================

                        const isTripCompleted =
                            transactionLower ===
                            'trip completed bonus';

                        html += `

                        <!-- MAIN ROW -->

                        <tr

                            ${
                                isTripCompleted
                                ?
                                `
                                class="clickable-row transaction-row main-row"
                                data-target="${detailId}"
                                `
                                :
                                'Class="transaction-row main-row'
                            }

                            data-transaction="${transactionLower}"
                            data-status="${statusLower}"
                            data-date="${row.raw_date}"
                        >

                            <td>
                                ${row.created_date}
                            </td>

                            <td>
                                <strong>
                                    ${row.entry_type}
                                </strong><br>

                                ${row.message ?? '-'}
                            </td>

                            <td>
                                ${row.booked_cust_name ?? '-'}<br>

                                <small>
                                    (${row.booked_cust_id ?? '-'})
                                </small>
                            </td>

                            <td>
                                ${row.trip_name ?? '-'}<br>

                                <small>
                                    ${row.reference_id ?? '-'}
                                </small>
                            </td>

                            <td>
                                ${paxCount}
                            </td>

                            <td>
                                ${
                                    perPaxBenefit !== '-'
                                    ?
                                    '₹' + perPaxBenefit
                                    :
                                    '-'
                                }
                            </td>

                            <td>
                                ${amountHtml}
                            </td>

                            <td>
                                <span class="badge ${badgeClass}">
                                    ${row.status ?? '-'}
                                </span>
                            </td>

                            <td>

                                ${
                                    isTripCompleted
                                    ?
                                    `
                                    <button class="toggle-btn btn btn-sm btn-light">

                                        <i class="fa-solid fa-chevron-down"></i>

                                    </button>
                                    `
                                    :
                                    `
                                    <button class="toggle-btn btn btn-sm btn-light">

                                        <i class="fa-solid fa-minus"></i>

                                    </button>
                                    `
                                }

                            </td>

                        </tr>

                        ${
                            isTripCompleted
                            ?
                            `

                            <!-- DETAILS ROW -->

                            <tr
                                class="details-row child-row"
                                id="${detailId}"
                                style="display:none;"
                            >

                                <td colspan="10">

                                    <div class="details-wrapper p-4 bg-light rounded">

                                        <div class="row g-4">

                                            <div class="col-lg-6">

                                                <div class="detail-card">

                                                    <h5 class="mb-3">

                                                        <i class="fa-solid fa-suitcase me-2"></i>

                                                        Trip Details

                                                    </h5>

                                                    <div class="mb-2">
                                                        <strong>Tour Name:</strong>
                                                        ${row.trip_name ?? '-'}
                                                    </div>

                                                    <div class="mb-2">
                                                        <strong>Destination:</strong>
                                                        ${row.trip_destination ?? '-'}
                                                    </div>

                                                    <div class="mb-2">
                                                        <strong>Travel Date:</strong>
                                                        ${row.trip_start_date ?? '-'}
                                                    </div>

                                                    <div class="mb-2">
                                                        <strong>Booking ID:</strong>
                                                        ${row.reference_id ?? '-'}
                                                    </div>

                                                    <div class="mb-2">
                                                        <strong>Booking Date:</strong>
                                                        ${row.booking_date ?? '-'}
                                                    </div>

                                                </div>

                                            </div>

                                            <div class="col-lg-6">

                                                <div class="detail-card">

                                                    <h5 class="mb-3">

                                                        <i class="fa-solid fa-users me-2"></i>

                                                        Passenger Details

                                                    </h5>

                                                    <table class="table table-bordered">

                                                        <thead>

                                                            <tr>

                                                                <th>Name</th>
                                                                <th>Age</th>
                                                                <th>Gender</th>

                                                            </tr>

                                                        </thead>

                                                        <tbody>

                                                            ${memberRows}

                                                        </tbody>

                                                    </table>

                                                </div>

                                            </div>

                                        </div>

                                    </div>

                                </td>

                            </tr>

                            `
                            :
                            ''
                        }

                        `;
                    });

                    tableBody.innerHTML = html;

                    totalTransactions.textContent =
                        res.data.length;

                    initFilters();
                    initExpandableRows();

                });

                // =========================
                // EXPANDABLE ROWS
                // =========================

                function initExpandableRows() {

                    const clickableRows =
                        document.querySelectorAll(
                            '.clickable-row'
                        );

                    clickableRows.forEach(row => {

                        row.addEventListener(
                            'click',
                            function () {

                                const target =
                                    row.dataset.target;

                                const details =
                                    document.getElementById(
                                        target
                                    );

                                const icon =
                                    row.querySelector(
                                        '.toggle-btn i'
                                    );

                                if (
                                    details.style.display
                                    === 'table-row'
                                ) {

                                    details.style.display =
                                        'none';

                                    icon.classList.remove(
                                        'fa-chevron-up'
                                    );

                                    icon.classList.add(
                                        'fa-chevron-down'
                                    );

                                } else {

                                    details.style.display =
                                        'table-row';

                                    icon.classList.remove(
                                        'fa-chevron-down'
                                    );

                                    icon.classList.add(
                                        'fa-chevron-up'
                                    );
                                }
                            }
                        );
                    });
                }

                // =========================
                // FILTERS
                // =========================

                function initFilters() {

                    allRows =
                        Array.from(
                            document.querySelectorAll(
                                '#transactionTableBody tr'
                            )
                        );

                    transactionFilter.addEventListener(
                        'change',
                        applyFilters
                    );

                    statusFilter.addEventListener(
                        'change',
                        applyFilters
                    );

                    dateFilter.addEventListener(
                        'change',
                        applyFilters
                    );
                }

                function applyFilters() {

                    const transactionValue =
                        transactionFilter.value.toLowerCase();

                    const statusValue =
                        statusFilter.value.toLowerCase();

                    const dateValue =
                        dateFilter.value;

                    let visibleCount = 0;

                    const mainRows =
                        document.querySelectorAll(
                            '#transactionTableBody tr[data-transaction]'
                        );

                    mainRows.forEach(row => {

                        const detailsRow =
                            row.dataset.target
                            ?
                            document.getElementById(
                                row.dataset.target
                            )
                            :
                            null;

                        const transaction =
                            row.dataset.transaction;

                        const status =
                            row.dataset.status;

                        const rowDate =
                            row.dataset.date;

                        let show = true;

                        if (
                            transactionValue !== 'all'
                            &&
                            transaction !== transactionValue
                        ) {
                            show = false;
                        }

                        if (
                            statusValue !== 'all'
                            &&
                            status !== statusValue
                        ) {
                            show = false;
                        }

                        if (
                            dateValue
                            &&
                            rowDate !== dateValue
                        ) {
                            show = false;
                        }

                        row.style.display =
                            show
                            ? ''
                            : 'none';

                        if (detailsRow) {

                            detailsRow.style.display =
                                'none';
                        }

                        if (show) {
                            visibleCount++;
                        }
                    });

                    totalTransactions.textContent =
                        visibleCount;
                }

            });
            //search feature
            $('#tableSearch').on('keyup', function () {

                let search = $(this).val().toLowerCase();

                $('.main-row').each(function () {

                    let found = false;

                    $(this).find('td').each(function () {

                        if ($(this).text().toLowerCase().includes(search)) {
                            found = true;
                            return false;
                        }

                    });

                    if (found) {
                        $(this).show();
                        // $(this).next('.child-row').show();
                    } else {
                        $(this).hide();
                        $(this).next('.child-row').hide();
                    }
                });

            });
            $('#clearSearch').on('click', function () {
                $('#tableSearch').val('').trigger('keyup').focus();
            });
            //search feature end
        </script>
        <!-- download logic -->
        <script>

            /*
            DOWNLOAD TABLE CSV
            */
            function downloadFilteredTableCSV(tableId, fileName = "statement.csv") {

                const table =
                    document.getElementById(tableId);

                if(!table){
                    return;
                }

                let csv = [];

                /*
                UTF-8 BOM FOR ₹ SYMBOL SUPPORT
                */
                csv.push("\uFEFF");

                /*
                TABLE HEADERS
                */
                let headers = [];

                table.querySelectorAll("thead th").forEach(function(th){

                    let text =
                        th.innerText
                        .replace(/[\n\r]+/g, ' ')
                        .replace(/,/g, ' ')
                        .replace(/"/g, '')
                        .replace(/\s+/g, ' ')
                        .trim();

                    /*
                    SKIP EMPTY HEADER
                    */
                    if(text !== ""){
                        headers.push(`"${text}"`);
                    }
                });

                csv.push(headers.join(","));

                /*
                ONLY MAIN TRANSACTION ROWS
                */
                const rows =
                    table.querySelectorAll("tbody tr.transaction-row");

                rows.forEach(function(row){

                    /*
                    SKIP FILTERED / HIDDEN ROWS
                    */
                    if(
                        window.getComputedStyle(row).display === "none"
                    ){
                        return;
                    }

                    let rowData = [];

                    row.querySelectorAll("td").forEach(function(td, index){

                        /*
                        SKIP LAST ICON COLUMN
                        */
                        if(index === row.cells.length - 1){
                            return;
                        }

                        let text =
                            td.innerText
                            .replace(/[\n\r]+/g, ' ')
                            .replace(/,/g, ' ')
                            .replace(/"/g, '')
                            .replace(/[^\x20-\x7E₹]/g, '')
                            .replace(/\(-\)/g, '')
                            .replace(/\(\+\)/g, '')
                            .replace(/^\-\s*/g, '')
                            .replace(/\s+/g, ' ')
                            .trim();

                        rowData.push(`"${text}"`);
                    });

                    csv.push(rowData.join(","));
                });

                /*
                FINAL CSV CONTENT
                */
                const csvContent =
                    csv.join("\n");

                /*
                CREATE DOWNLOAD FILE
                */
                const blob =
                    new Blob(
                        [csvContent],
                        {
                            type: "text/csv;charset=utf-8;"
                        }
                    );

                const link =
                    document.createElement("a");

                const url =
                    URL.createObjectURL(blob);

                link.setAttribute("href", url);

                link.setAttribute("download", fileName);

                document.body.appendChild(link);

                link.click();

                document.body.removeChild(link);
            }

            /*
            DOWNLOAD BUTTON CLICK
            */
            $("#downloadBtn").on("click", function(){

                downloadFilteredTableCSV(
                    "transactionTable",
                    "discount-wallet-statement.csv"
                );
            });

        </script>
        <!-- download logic -->
    </body>
</html>