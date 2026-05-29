<?php
    include_once (__DIR__ .'/../../dashboard_user_details.php');
    include (__DIR__ . '/../customer_model.php');
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
        <link rel="stylesheet" href="<?= $base_url ?>assets/css/neo_select/customer_loyalty_coupon.css" />
        <link rel="stylesheet" href="<?= $base_url ?>assets/css/neo_select/earn_coupon_modal.css" />
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
                        <!-- =========================
                        LOYALTY PAGE CONTENT
                        (EXCLUDING HEADER & SIDEBAR)
                        ========================= -->

                        <div class="container-fluid loyalty-page">

                            <!-- TITLE -->

                            <div class="d-flex justify-content-between align-items-start flex-wrap gap-3">

                                <div>

                                    <div class="d-flex align-items-center gap-2">

                                        <h2 class="loyalty-title mb-0">
                                            My Loyalty Coupons
                                        </h2>

                                        <i class="fa-solid fa-award loyalty-title-icon"></i>

                                    </div>

                                    <p class="loyalty-subtitle">
                                        Earn loyalty coupons after completing your trips and use them on your next bookings.
                                    </p>

                                </div>

                                <button class="btn loyalty-help-btn" id="openEarnCouponModal">
                                    <i class="fa-regular fa-circle-play me-2"></i>
                                    How Loyalty Coupons Work?
                                </button>

                            </div>

                            <!-- SUMMARY -->

                            <div class="row g-4 mt-1">

                                <!-- TOTAL -->

                                <div class="col-lg-3 col-md-6">
                                    <div class="loyalty-summary-card green-card position-relative overflow-hidden">

                                        <!-- Watermark Icon -->
                                        <div class="watermark-icon">
                                            <i class="fa-solid fa-gift"></i>
                                        </div>

                                        <!-- Main Icon -->
                                        <div class="summary-icon green-bg">
                                            <i class="fa-solid fa-gift"></i>
                                        </div>

                                        <!-- Content -->
                                        <div class="summary-label d-flex justify-content-between align-items-center">
                                            <span>Total Loyalty Coupons</span>
                                            <span class="summary-value"><?= $loyaltyCouponData['coupon_total'] ?></span>
                                        </div>

                                    </div>
                                </div>

                                <!-- AVAILABLE -->
                                <div class="col-lg-3 col-md-6">
                                    <div class="loyalty-summary-card mint-card position-relative overflow-hidden">

                                        <!-- Watermark -->
                                        <div class="watermark-icon mint-watermark">
                                            <i class="fa-solid fa-circle-check"></i>
                                        </div>

                                        <div class="summary-icon mint-bg">
                                            <i class="fa-solid fa-circle-check"></i>
                                        </div>
                                        <!-- Content -->
                                        <div class="summary-label d-flex justify-content-between align-items-center mb-n3">
                                            <span>Available Coupons</span>
                                            <span class="summary-value"><?= $loyaltyCouponData['active_coupon_total'] ?></span>
                                        </div>

                                        <div class="summary-sub-value green-text">
                                            Value ₹<?= $loyaltyCouponData['active_total_value'] ?>
                                        </div>

                                    </div>
                                </div>

                                <!-- USED -->
                                <div class="col-lg-3 col-md-6">
                                    <div class="loyalty-summary-card yellow-card position-relative overflow-hidden">

                                        <!-- Watermark -->
                                        <div class="watermark-icon yellow-watermark">
                                            <i class="fa-regular fa-clock"></i>
                                        </div>

                                        <div class="summary-icon yellow-bg">
                                            <i class="fa-regular fa-clock"></i>
                                        </div>
                                        <!-- Content -->
                                        <div class="summary-label d-flex justify-content-between align-items-center mb-n2">
                                            <span>Used / Expired Coupons</span>
                                            <span class="summary-value"><?= $loyaltyCouponData['used_coupon_total'] + $loyaltyCouponData['expired_coupon_total'] ?> </span>
                                        </div>

                                        <div class="summary-sub-value">
                                            Value ₹<?= $loyaltyCouponData['used_total_value'] + $loyaltyCouponData['expired_total_value'] ?>
                                        </div>

                                    </div>
                                </div>

                                <!-- TOTAL VALUE -->
                                <div class="col-lg-3 col-md-6">
                                    <div class="loyalty-summary-card purple-card position-relative overflow-hidden">

                                        <!-- Watermark -->
                                        <div class="watermark-icon purple-watermark">
                                            <i class="fa-regular fa-calendar-days"></i>
                                        </div>

                                        <div class="summary-icon purple-bg">
                                            <i class="fa-regular fa-calendar-days"></i>
                                        </div>

                                        <div class="summary-label">
                                            Total Value
                                        </div>

                                        <div class="summary-big-value">
                                            ₹<?= $loyaltyCouponData['coupon_total_value'] ?>
                                        </div>

                                    </div>
                                </div>

                            </div>

                            <!-- FEATURE STRIP -->

                            <div class="feature-strip mt-4">

                                <div class="row text-center">

                                    <div class="col-lg-4">
                                        <div class="feature-item">
                                            <i class="fa-solid fa-user"></i>
                                            ₹500 per passenger travelled
                                        </div>
                                    </div>

                                    <div class="col-lg-4">
                                        <div class="feature-item">
                                            <i class="fa-regular fa-calendar"></i>
                                            Valid for 12 months from the date of credit
                                        </div>
                                    </div>

                                    <div class="col-lg-4">
                                        <div class="feature-item">
                                            <i class="fa-solid fa-tags"></i>
                                            Usable on eligible bookings only
                                        </div>
                                    </div>

                                </div>

                            </div>

                            <!-- TABLE CARD -->

                            <div class="table-card mt-4 position-relative overflow-hidden">

                                <!-- Watermark -->
                                <div class="table-watermark">
                                    <i class="fa-solid fa-ticket"></i>
                                </div>

                                <!-- TABS -->

                                <div class="tabs-wrapper py-2">

                                    <div class="coupon-tabs-nav">

                                        <button class="coupon-tab active" data-filter="all">
                                            All Loyalty Coupons
                                            <span class="tab-count"><?= $loyaltyCouponData['coupon_total'] ?></span>
                                        </button>

                                        <button class="coupon-tab available-tab" data-filter="available">
                                            Available
                                            <span class="tab-count"><?= $loyaltyCouponData['active_coupon_total'] ?></span>
                                        </button>

                                        <button class="coupon-tab used-tab" data-filter="used">
                                            Used
                                            <span class="tab-count"><?= $loyaltyCouponData['used_coupon_total'] ?></span>
                                        </button>

                                        <button class="coupon-tab expired-tab" data-filter="expired">
                                            Expired
                                            <span class="tab-count"><?= $loyaltyCouponData['expired_coupon_total'] ?></span>
                                        </button>

                                    </div>

                                </div>

                                <!-- FILTERS -->

                                <div class="filter-area">

                                    <div class="row align-items-end g-3">

                                        <div class="col-lg-3">
                                            <label class="filter-label">
                                                Sort by
                                            </label>

                                            <select class="form-select">
                                                <option>Latest First</option>
                                                <option>Oldest First</option>
                                            </select>
                                        </div>

                                        <div class="col-lg-3">
                                            <label class="filter-label">
                                                Status
                                            </label>

                                            <select class="form-select">
                                                <option>All</option>
                                                <option>Available</option>
                                                <option>Used</option>
                                                <option>Expired</option>
                                            </select>
                                        </div>

                                        <div class="col-lg-3">
                                            <label class="filter-label">
                                                Valid Till
                                            </label>

                                            <input type="date" class="form-control form-select">
                                        </div>

                                        <div class="col-lg-3 text-lg-end">

                                            <button class="btn download-btn" id="downloadBtn">
                                                <i class="fa-solid fa-download me-2"></i>
                                                Download List
                                            </button>

                                        </div>

                                    </div>

                                </div>

                                <!-- TABLE -->

                                <div class="table-responsive">

                                    <table class="table loyalty-table align-middle transaction-table" id="transactionTable">

                                        <thead>

                                            <tr>

                                                <th>Coupon Code</th>
                                                <th>Value</th>
                                                <th>Status</th>
                                                <th>Valid Till</th>
                                                <th>Earned On</th>
                                                <th>Earned For</th>
                                                <th>Used On</th>

                                            </tr>

                                        </thead>

                                        <tbody id="loyaltyTableBody">

                                        </tbody>

                                    </table>

                                </div>
                                <div class="mt-3">
                                    <div class="neo-info-strip-wrapper">
                                    <!-- TOP LEFT HEADING -->
                                    <div class="neo-info-strip-heading">
                                        Important Information
                                    </div>
                                    <div class="neo-info-strip">
                                        <div class="neo-info-item">
                                            <div class="neo-info-icon">
                                                <i class="fa-solid fa-ticket"></i>
                                            </div>
                                            <p>
                                                Loyalty coupons are credited after the successful completion of your trip.
                                            </p>
                                        </div>
                                        <div class="neo-info-divider"></div>
                                        <div class="neo-info-item">
                                            <div class="neo-info-icon">
                                                <i class="fa-solid fa-calendar-days"></i>
                                            </div>
                                            <p>
                                                Each loyalty coupon is valid for12 months from the date of credit.
                                            </p>
                                        </div>
                                        <div class="neo-info-divider"></div>
                                        <div class="neo-info-item">
                                            <div class="neo-info-icon">
                                                <i class="fa-solid fa-circle-check"></i>
                                            </div>
                                            <p>
                                                These coupons cannot be exchanged for cash or transferred.
                                            </p>
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
        <?= include (__DIR__ .'/earn_coupon_modal.php') ?>

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
         <!-- =========================
        JAVASCRIPT
        ========================= -->

        <script>

            /*
            LOYALTY COUPON TABLE AJAX
            */
            $.ajax({

                url: "<?= $base_url_cust ?>ajax/loyalty_coupon_table.php",

                type: "POST",

                dataType: "json",

                success: function(response){

                    let html = "";

                    if(response.status && response.data.length > 0){

                        response.data.forEach(function(item){

                            /*
                            DEFAULT STATUS
                            */
                            let statusText = "";
                            let statusClass = "";
                            let rowStatus = "";

                            /*
                            STATUS CHECK
                            */
                            if(parseInt(item.usage_status) === 1){

                                statusText = "Used";
                                statusClass = "status-used";
                                rowStatus = "used";
                            }
                            else{

                                statusText = "Available";
                                statusClass = "status-available";
                                rowStatus = "available";
                            }

                            /*
                            DATE VALUES
                            */
                            const earnedFormatted =
                                item.created_date_text || "-";

                            const validFormatted =
                                item.expiry_date_text || "-";

                            /*
                            EXPIRY CALCULATION
                            */
                            const today =
                                new Date();

                            const expiryDate =
                                new Date(item.expiry_date);

                            /*
                            REMOVE TIME
                            */
                            today.setHours(0,0,0,0);
                            expiryDate.setHours(0,0,0,0);

                            const diffTime =
                                expiryDate - today;

                            const diffDays =
                                Math.ceil(diffTime / (1000 * 60 * 60 * 24));

                            /*
                            VALID TEXT
                            */
                            let validText = "";

                            /*
                            EXPIRED
                            */
                            if(
                                parseInt(item.usage_status) === 0 &&
                                diffDays <= 0
                            ){

                                rowStatus = "expired";

                                statusText = "Expired";

                                statusClass = "status-expired";

                                /*
                                EXPIRED TODAY
                                */
                                if(diffDays === 0){

                                    validText = `
                                        <div class="text-danger small">
                                            Expired Today
                                        </div>
                                    `;
                                }

                                /*
                                EXPIRED BEFORE
                                */
                                else{

                                    const expiredDays =
                                        Math.abs(diffDays);

                                    validText = `
                                        <div class="text-danger small">
                                            Expired ${expiredDays}
                                            Day${expiredDays > 1 ? 's' : ''} Ago
                                        </div>
                                    `;
                                }
                            }

                            /*
                            USED
                            */
                            else if(rowStatus === "used"){

                                validText = `
                                    <div class="text-danger small">
                                        Used
                                    </div>
                                `;
                            }

                            /*
                            AVAILABLE
                            */
                            else{

                                validText = `
                                    <div class="days-left">
                                        ${diffDays}
                                        Day${diffDays > 1 ? 's' : ''} Left
                                    </div>
                                `;
                            }

                            /*
                            USED DATE
                            */
                            let usedDateHtml = `
                                <span class="text-muted">—</span>
                            `;

                            if(item.used_date){

                                usedDateHtml = `

                                    ${item.used_date_text}

                                    ${
                                        item.transaction_id &&
                                        item.transaction_id !== '-'

                                        ? `
                                            <div class="small text-muted">
                                                ${item.transaction_id}
                                            </div>
                                        `
                                        : ''
                                    }
                                `;
                            }

                            /*
                            EARNED FOR
                            */
                            let earnedFor =
                                item.earned_for || "Membership Bonus";

                            /*
                            REMOVE DUPLICATE BOOKING ID
                            */
                            earnedFor =
                                earnedFor
                                .replace(/Booking ID:.*/gi, '')
                                .trim();

                            /*
                            TABLE HTML
                            */
                            html += `

                                <tr Class="transaction-row data-status="${rowStatus}">

                                    <td>

                                        <div class="coupon-box">

                                            ${item.code}

                                            <div>
                                                ₹${item.coupon_amt}
                                            </div>

                                        </div>

                                    </td>

                                    <td class="coupon-price">
                                        ₹${item.coupon_amt}
                                    </td>

                                    <td>

                                        <span class="status-badge ${statusClass}">
                                            ${statusText}
                                        </span>

                                    </td>

                                    <td>

                                        ${validFormatted}

                                        ${validText}

                                    </td>

                                    <td>
                                        ${earnedFormatted}
                                    </td>

                                    <td>

                                        ${earnedFor}

                                        ${
                                            item.used_on &&
                                            item.used_on !== '-'

                                            ? `
                                                <div class="small text-muted">

                                                    Used On:
                                                    ${item.used_on}

                                                    ${
                                                        item.transaction_id &&
                                                        item.transaction_id !== '-'

                                                        ? `<br>Booking ID: ${item.transaction_id}`

                                                        : ''
                                                    }

                                                </div>
                                            `
                                            : ''
                                        }

                                    </td>

                                    <td>
                                        ${usedDateHtml}
                                    </td>

                                </tr>
                            `;
                        });
                    }
                    else{

                        html = `

                            <tr>

                                <td colspan="7"
                                    class="text-center py-4 text-muted fw-bold">

                                    No Coupons Found

                                </td>

                            </tr>
                        `;
                    }

                    /*
                    APPEND TABLE
                    */
                    $("#loyaltyTableBody").html(html);

                    /*
                    FILTER TABS
                    */
                    const tabs =
                        document.querySelectorAll('.coupon-tab');

                    tabs.forEach(tab => {

                        tab.addEventListener('click', function () {

                            tabs.forEach(btn => {
                                btn.classList.remove('active');
                            });

                            this.classList.add('active');

                            const filter =
                                this.dataset.filter;

                            const rows =
                                document.querySelectorAll('#loyaltyTableBody tr');

                            rows.forEach(row => {

                                const status =
                                    row.dataset.status;

                                if(
                                    filter === 'all' ||
                                    status === filter
                                ){

                                    row.style.display =
                                        'table-row';
                                }
                                else{

                                    row.style.display =
                                        'none';
                                }
                            });
                        });
                    });
                }
            });

        </script>
        <!-- download logic -->
        <script>

            /*
            DOWNLOAD TABLE CSV
            */
            function downloadFilteredTableCSV(
                tableId,
                fileName = "statement.csv"
            ) {

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

                    headers.push(`"${text}"`);
                });

                csv.push(headers.join(","));

                /*
                ONLY MAIN TRANSACTION ROWS
                */
                const rows =
                    table.querySelectorAll(
                        "tbody tr.transaction-row"
                    );

                rows.forEach(function(row){

                    /*
                    SKIP HIDDEN / FILTERED ROWS
                    */
                    if(
                        window.getComputedStyle(row).display === "none"
                    ){
                        return;
                    }

                    let rowData = [];

                    row.querySelectorAll("td").forEach(function(td){

                        let text =
                            td.innerText;

                        /*
                        CLEAN TEXT
                        */
                        text = text
                            .replace(/[\n\r]+/g, ' ')
                            .replace(/,/g, ' ')
                            .replace(/"/g, '')
                            .replace(/[^\x20-\x7E₹]/g, '')
                            .replace(/\(-\)/g, '')
                            .replace(/\(\+\)/g, '')
                            .replace(/^\-\s*/g, '')
                            .replace(/\s+/g, ' ')
                            .trim();

                        /*
                        REMOVE STANDALONE -
                        */
                        if(text === "-"){
                            text = "";
                        }

                        /*
                        REMOVE "- " BEFORE IDS
                        */
                        text = text
                            .replace(/-\s*CU/gi, 'CU')
                            .replace(/-\s*WD/gi, 'WD');

                        rowData.push(`"${text}"`);
                    });

                    csv.push(rowData.join(","));
                });

                /*
                FINAL CSV
                */
                const csvContent =
                    csv.join("\n");

                /*
                CREATE FILE
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
            DOWNLOAD BUTTON
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