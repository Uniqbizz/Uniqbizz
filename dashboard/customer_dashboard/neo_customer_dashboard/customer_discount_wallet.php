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
        <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SZ4qk6V... (auto-generated)" crossorigin="anonymous" referrerpolicy="no-referrer"> -->
        <link rel="stylesheet" href="<?= $base_url ?>assets/css/neo_select/customer_discount_wallet.css" />
        <link rel="stylesheet" href="<?= $base_url ?>assets/css/neo_select/customer_discount_modal.css" />
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
                        <!-- customer discount wallet -->

                        <div class="page-title">

                            <div class="title-left">

                                <div class="title-icon">
                                    <i class="fa-solid fa-percent"></i>
                                </div>

                                <div>
                                    <h1>Discount Wallet Transactions</h1>
                                    <p>Track all your wallet activities and savings.</p>
                                </div>

                            </div>

                            <button class="info-btn" id="neoxdwOpenModalBtn">
                                <i class="fa-solid fa-circle-info"></i>
                                How Discount Wallet Works?
                            </button>

                        </div>

                        <!-- STATS -->
                        <div class="stats-grid">

                            <div class="stat-card">

                                <div class="stat-top">
                                    <div class="stat-icon purple">
                                        <i class="fa-solid fa-wallet"></i>
                                    </div>
                                </div>

                                <p>Total Savings</p>
                                <h2 class="purple-text mb-n3">₹<?= $disWalletData['total_discount_earned'] ?? 0?></h2>

                                <!--<div class="sub-data">-->
                                <!--    <div>-->
                                <!--        This Year-->
                                <!--        <strong>₹2,000</strong>-->
                                <!--    </div>-->

                                <!--    <div>-->
                                <!--        Last Year-->
                                <!--        <strong>₹400</strong>-->
                                <!--    </div>-->
                                <!--</div>-->

                            </div>

                            <div class="stat-card">

                                <div class="stat-top">
                                    <div class="stat-icon green">
                                        <i class="fa-solid fa-sack-dollar"></i>
                                    </div>
                                </div>

                                <p>Available Balance</p>
                                <h2 class="green-text mb-n3">₹<?= $disWalletData['balance'] ?? 0 ?></h2>

                                <!--<div class="sub-data">-->
                                <!--    <div>-->
                                <!--        Used This Year-->
                                <!--        <strong>₹800</strong>-->
                                <!--    </div>-->

                                <!--    <div>-->
                                <!--        On Hold-->
                                <!--        <strong>₹400</strong>-->
                                <!--    </div>-->
                                <!--</div>-->

                            </div>

                            <div class="stat-card">

                                <div class="stat-top">
                                    <div class="stat-icon blue">
                                        <i class="fa-solid fa-tags"></i>
                                    </div>
                                </div>

                                <p>Total Discounts Used</p>
                                <h2 style="color:#2563eb;" class="mb-n3">₹<?= $disWalletData['total_discount_used'] ?? 0 ?></h2>

                                <!--<div class="sub-data">-->
                                <!--    <div>-->
                                <!--        Bookings-->
                                <!--        <strong>6</strong>-->
                                <!--    </div>-->

                                <!--    <div>-->
                                <!--        Passengers-->
                                <!--        <strong>14</strong>-->
                                <!--    </div>-->
                                <!--</div>-->

                            </div>

                            <!--<div class="stat-card">-->

                            <!--    <div class="stat-top">-->
                            <!--        <div class="stat-icon orange">-->
                            <!--            <i class="fa-solid fa-calendar-xmark"></i>-->
                            <!--        </div>-->
                            <!--    </div>-->

                            <!--    <p>Total Expired</p>-->
                            <!--    <h2 class="orange-text mb-n3">₹400</h2>-->

                            <!--    <div class="sub-data">-->
                            <!--        <div>-->
                            <!--            This Year-->
                            <!--            <strong>₹400</strong>-->
                            <!--        </div>-->

                            <!--        <div>-->
                            <!--            Last Year-->
                            <!--            <strong>₹0</strong>-->
                            <!--        </div>-->
                            <!--    </div>-->

                            <!--</div>-->

                        </div>

                        <!-- NOTICE -->
                        <div class="notice-bar">

                            <div class="notice-item">
                                <i class="fa-solid fa-tag"></i>
                                Discounts can be used on eligible bookings only
                            </div>

                            <div class="notice-item">
                                <i class="fa-solid fa-ban"></i>
                                Cannot be withdrawn or transferred
                            </div>

                            <div class="notice-item">
                                <i class="fa-solid fa-calendar-days"></i>
                                Valid for 12 months from date of credit
                            </div>

                        </div>

                        <!-- FILTERS -->
                        <div class="filter-bar">

                            <div class="filters">

                                <div class="filter-group">
                                    <label>Transaction Type</label>

                                    <select id="typeFilter">
                                        <option value="all">All</option>
                                        <option value="earned">Earned</option>
                                        <option value="used">Used</option>
                                        <!--<option value="expired">Expired</option>-->
                                    </select>
                                </div>

                                <div class="filter-group">
                                    <label>Status</label>

                                    <select id="statusFilter">
                                        <option value="all">All</option>
                                        <option value="credited">Credited</option>
                                        <option value="used">Used</option>
                                        <!--<option value="expired">Expired</option>-->
                                    </select>
                                </div>

                                <div class="filter-group">
                                    <label>Date Range</label>

                                    <input type="date">
                                </div>

                            </div>

                            <button class="download-btn" id="downloadBtn">
                                <i class="fa-solid fa-download"></i>
                                Download Statement
                            </button>

                        </div>

                        <!-- TABLE -->
                        <div class="table-card">

                            <div class="table-header">
                                <h2>All Transactions (0)</h2>
                            </div>

                            <table class="transaction-table" id="transactionTable">

                                <thead>

                                    <tr>
                                        <th>Date & Time</th>
                                        <th>Description</th>
                                        <th>Trip Details</th>
                                        <th>Type</th>
                                        <th>Amount</th>
                                        <th>Status</th>
                                        <!--<th>Balance</th>-->
                                        <th></th>
                                    </tr>

                                </thead>

                                <tbody id="transactionBody">

                                    

                                </tbody>

                            </table>

                        </div>

                        <!-- NOTE -->

                        <div class="bottom-note">
                            <strong>Note:</strong>
                            Discount wallet balance can be used on eligible bookings only.
                            Discounts cannot be withdrawn or transferred.
                        </div>

                        <!-- HOW TO USE -->

                        <div class="how-use">

                            <h2>How You Can Use Your Discount Wallet?</h2>

                            <div class="how-grid">

                                <div class="how-card">
                                    <i class="fa-solid fa-ticket"></i>
                                    <h4>Use on Eligible Bookings</h4>
                                    <p>
                                        Apply your discount on holiday packages,
                                        group tours and events.
                                    </p>
                                </div>

                                <div class="how-card">
                                    <i class="fa-solid fa-user-group"></i>
                                    <h4>One Discount Per Passenger</h4>
                                    <p>
                                        Discount is applicable per passenger
                                        per booking.
                                    </p>
                                </div>

                                <div class="how-card">
                                    <i class="fa-solid fa-bolt"></i>
                                    <h4>Auto Apply at Checkout</h4>
                                    <p>
                                        Eligible discounts are automatically
                                        applied during booking.
                                    </p>
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
        <?= include 'customer_discount_modal.php' ?>

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
        <!-- <script>

            // EXPANDABLE TABLE

            const transactionRows = document.querySelectorAll(".transaction-row");

            transactionRows.forEach(row => {

                row.addEventListener("click", () => {

                    const details = row.nextElementSibling;

                    if(details.style.display === "table-row"){
                        details.style.display = "none";
                    }else{
                        details.style.display = "table-row";
                    }

                });

            });

            // FILTERS

            const typeFilter = document.getElementById("typeFilter");
            const statusFilter = document.getElementById("statusFilter");

            function filterTransactions(){

                const rows = document.querySelectorAll(".transaction-row");

                rows.forEach(row => {

                    const type = row.dataset.type;
                    const status = row.dataset.status;

                    const typeValue = typeFilter.value;
                    const statusValue = statusFilter.value;

                    const typeMatch =
                        typeValue === "all" || type === typeValue;

                    const statusMatch =
                        statusValue === "all" || status === statusValue;

                    if(typeMatch && statusMatch){

                        row.style.display = "";

                        if(row.nextElementSibling.classList.contains("details-row")){
                            row.nextElementSibling.style.display = "none";
                        }

                    }else{

                        row.style.display = "none";

                        if(row.nextElementSibling.classList.contains("details-row")){
                            row.nextElementSibling.style.display = "none";
                        }

                    }

                });

            }

            typeFilter.addEventListener("change", filterTransactions);
            statusFilter.addEventListener("change", filterTransactions);

            // DOWNLOAD BUTTON

            document.querySelector(".download-btn")
            .addEventListener("click", () => {

                alert("Statement Download Started!");

            });

            // MEMBERSHIP BUTTON

            document.querySelector(".membership button")
            .addEventListener("click", () => {

                alert("Redirecting to Membership Details");

            });

            // INFO BUTTON

            document.querySelector(".info-btn")
            .addEventListener("click", () => {

                alert(
                    "Discount Wallet allows you to earn and use discounts on eligible travel bookings."
                );

            });

        </script> -->
        <script>

            $.ajax({

                url: "<?= $base_url_cust ?>ajax/discount_wallet_history.php",

                type: "POST",

                dataType: "json",

                success: function(response){

                    let html = "";

                    if(response.status && response.data.length > 0){

                        $(".table-header h2").html(
                            `All Transactions (${response.data.length})`
                        );

                        response.data.forEach(function(item){

                            /*
                            DATE
                            */
                            const splitDate =
                                item.created_date_text.split(' ');

                            const dateText =
                                splitDate.slice(0, 3).join(' ');

                            const timeText =
                                splitDate.slice(3).join(' ');

                            /*
                            TYPE
                            */
                            const isUsed =
                                item.type === "used";

                            const typeBadge =
                                isUsed
                                ? "used"
                                : "earned";

                            const amountClass =
                                isUsed
                                ? "red-text"
                                : "green-text";

                            const amountPrefix =
                                isUsed
                                ? "-"
                                : "+";

                            /*
                            STATUS
                            */
                            let statusText = "";
                            let statusBadge = "";

                            if(isUsed){

                                statusText = "Used";
                                statusBadge = "used";

                            }
                            else{

                                statusText = "Credited";
                                statusBadge = "earned";
                            }

                            /*
                            DESCRIPTION
                            */
                            const tripName =
                                item.message || "-";

                            html += `

                                <tr class="transaction-row"
                                    data-type="${item.type}"
                                    data-status="${item.status}">

                                    <td>
                                        <strong>
                                            ${dateText}
                                        </strong>

                                        <br>

                                        <small>
                                            ${timeText}
                                        </small>

                                    </td>

                                    <td>

                                        <strong>
                                            ${item.description}
                                        </strong>

                                        <br>

                                        <small>
                                            ${tripName}
                                        </small>

                                    </td>

                                    <td>

                                        <strong>
                                            ${tripName}
                                        </strong>

                                        <br>

                                        <small>
                                            Booking ID:
                                            ${item.transaction_id}
                                        </small>

                                    </td>

                                    <td>

                                        <span class="badge ${typeBadge}">
                                            ${isUsed ? 'Used' : 'Earned'}
                                        </span>

                                    </td>

                                    <td class="${amountClass}">

                                        <strong>
                                            ${amountPrefix}₹${item.amount}
                                        </strong>

                                    </td>

                                    <td>

                                        <span class="badge ${statusBadge}">
                                            ${statusText}
                                        </span>

                                    </td>

                                    <td>

                                        <i class="fa-solid fa-chevron-down"></i>

                                    </td>

                                </tr>

                                <tr class="details-row">

                                    <td colspan="8">

                                        <div class="details-content">

                                            <div class="details-box">

                                                <h4>

                                                    <i class="fa-solid fa-suitcase"></i>

                                                    Transaction Details

                                                </h4>

                                                <div class="detail-item">

                                                    <span>
                                                        Description
                                                    </span>

                                                    <strong>
                                                        ${item.description}
                                                    </strong>

                                                </div>

                                                <div class="detail-item">

                                                    <span>
                                                        Booking ID
                                                    </span>

                                                    <strong>
                                                        ${item.transaction_id}
                                                    </strong>

                                                </div>

                                                <div class="detail-item">

                                                    <span>
                                                        Created On
                                                    </span>

                                                    <strong>
                                                        ${item.created_date_text}
                                                    </strong>

                                                </div>

                                            </div>

                                            <div class="details-box">

                                                <h4>

                                                    <i class="fa-solid fa-money-bill-wave"></i>

                                                    Amount Details

                                                </h4>

                                                <div class="detail-item">

                                                    <span>
                                                        Transaction Amount
                                                    </span>

                                                    <strong class="${amountClass}">
                                                        ₹${item.amount}
                                                    </strong>

                                                </div>

                                                <div class="detail-item">

                                                    <span>
                                                        Wallet Balance
                                                    </span>

                                                    <strong>
                                                        ₹${item.balance}
                                                    </strong>

                                                </div>

                                                <div class="detail-item">

                                                    <span>
                                                        Status
                                                    </span>

                                                    <strong>
                                                        ${statusText}
                                                    </strong>

                                                </div>

                                            </div>

                                        </div>

                                    </td>

                                </tr>
                            `;
                        });
                    }
                    else{

                        html = `

                            <tr>

                                <td colspan="7"
                                    class="text-center py-5 fw-bold text-muted">

                                    No Transactions Found

                                </td>

                            </tr>
                        `;
                    }

                    $("#transactionBody").html(html);

                    /*
                    FILTERS
                    */
                    function applyFilters(){

                        const typeFilter =
                            $("#typeFilter").val();

                        const statusFilter =
                            $("#statusFilter").val();

                        $(".transaction-row").each(function(){

                            const row =
                                $(this);

                            const rowType =
                                row.data("type");

                            const rowStatus =
                                row.data("status");

                            const typeMatch =
                                typeFilter === "all" ||
                                rowType === typeFilter;

                            const statusMatch =
                                statusFilter === "all" ||
                                rowStatus === statusFilter;

                            if(typeMatch && statusMatch){

                                row.show();
                                row.next(".details-row").show();
                            }
                            else{

                                row.hide();
                                row.next(".details-row").hide();
                            }
                        });
                    }

                    $("#typeFilter, #statusFilter").on(
                        "change",
                        applyFilters
                    );

                    /*
                    DETAILS TOGGLE
                    */
                    $(document).on(
                        "click",
                        ".transaction-row",
                        function(){

                            $(this)
                            .next(".details-row")
                            .toggle();
                        }
                    );

                    /*
                    INITIALLY HIDE DETAILS
                    */
                    $(".details-row").hide();
                }
            });

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