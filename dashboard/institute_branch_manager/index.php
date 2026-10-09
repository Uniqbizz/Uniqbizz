<?php
    include_once(__DIR__ . '/../dashboard_user_details.php');
    include 'urls.php';
?>
<!doctype html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg" data-sidebar-image="none" data-preloader="disable">
    <head>
        <meta charset="utf-8" />
        <title>IBR Dashboard</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!-- App favicon -->
        <link rel="shortcut icon" href="../assets/images/fav.png">

        <!-- jsvectormap css -->
        <link href="../assets/libs/jsvectormap/css/jsvectormap.min.css" rel="stylesheet" type="text/css" />

        <!--Swiper slider css-->
        <link href="../assets/libs/swiper/swiper-bundle.min.css" rel="stylesheet" type="text/css" />

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
        
        
        <!-- FontAwesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <!-- GOOGLE FONT -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

        <!-- FONT AWESOME -->
        <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"> -->

        <!-- CHART JS -->
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <link rel="stylesheet" href="../assets/css/ibr_index.css" />
        
    </head>

    <body class="twocolumn-panel">
        <!-- Begin page -->
        <div id="layout-wrapper">
            <?php include_once "ibr_header.php" ?>

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

            <?php include_once "ibr_sidebar.php" ?>
            <!-- ============================================================== -->
            <!-- Start of Customer Dashboard here -->
            <!-- ============================================================== -->
            <div class="main-content">
                <div class="page-content">
                    <div class="container-fluid ps-0">
                        <!-- Super Techno Enterprisee Dashboard Greeting Card -->
                        <div class="card border rounded-4 shadow-sm overflow-hidden">
                            <div class="greetingImageWrapper">
                                <img src="../assets/images/superTechnoImage.png" alt="Package" class="greetingImage img-fluid w-100">
                            </div>
                            <div class="greetingCard">
                                <p class="fw-bold text-dark gap-3 fs-4">Welcome Back,<span class="" id="userName"></span>! &#128075;</p>
                                <h1 class="fw-bold text-dark gap-3">Institution Branch Manager</h1>
                                <p class="text-dark fs-4 mb-0">You're building something great.</p>
                                <p class="text-dark fs-4">Here's your business overview.</p>
                            </div>
                        </div>

                        <!-- TOP CARDS -->
                        <div class="neo-top-stats-grid">

                            <div class="neo-stat-card neo-blue-card neo-card-watermark neo-blue-watermark">
                                <div class="neo-stat-card-header">
                                    <div class="neo-stat-icon neo-blue-icon">
                                        <i class="fa-solid fa-id-card"></i>
                                    </div>

                                    <div>
                                        <h4>Neo Select Enrollments</h4>
                                        <h2 id="cuCount">0</h2>
                                        <!--<p>This Month</p>-->
                                    </div>
                                </div>
                                <!-- NEW IMAGE SECTION -->
                                <div class="neo-enrollment-visual-box">

                                    <div class="neo-enrollment-user-card">
                                        <i class="fa-solid fa-user-plus"></i>
                                    </div>

                                    <div class="neo-enrollment-user-card">
                                        <i class="fa-solid fa-address-card"></i>
                                    </div>

                                    <div class="neo-enrollment-user-card">
                                        <i class="fa-solid fa-clipboard-check"></i>
                                    </div>

                                    <div class="neo-enrollment-user-card active">
                                        <i class="fa-solid fa-circle-check"></i>
                                    </div>

                                </div>
                            </div>

                            <div class="neo-stat-card neo-green-card neo-card-watermark neo-green-watermark">
                                <div class="neo-stat-card-header">
                                    <div class="neo-stat-icon neo-green-icon">
                                        <i class="fa-solid fa-sack-dollar"></i>
                                    </div>

                                    <div>
                                        <h4>Commission Earned</h4>
                                        <h2 id="cuComm">₹ 0</h2>
                                        <p id="perCuComm">0 Customers × ₹0</p>
                                    </div>
                                </div>

                                <div class="neo-mini-grid-boxes">
                                    <div>
                                        <span>Paid Commission</span>
                                        <strong id="cuCommPaid">₹ 0</strong>
                                    </div>

                                    <div>
                                        <span>Pending Payout</span>
                                        <strong id="cuCommPending">₹ 0</strong>
                                    </div>
                                </div>
                            </div>

                            <div class="neo-stat-card neo-purple-card neo-card-watermark neo-purple-watermark">
                                <div class="neo-stat-card-header neo-flex-start">
                                    <div class="neo-stat-icon neo-purple-icon">
                                        <i class="fa-solid fa-gift"></i>
                                    </div>

                                    <div>
                                        <h4>Holiday Bookings</h4>
                                        <h2 id="bookingCount">0</h2>
                                    </div>
                                </div>

                                <div class="neo-booking-mini-list">
                                    <!-- <div><span>Goa Packages</span> <strong>12</strong></div> -->
                                    <!--<div><span>Dubai</span> <strong>4</strong></div>-->
                                    <!-- <div><span>Singapore</span> <strong>2</strong></div>
                                    <div><span>Others</span> <strong>0</strong></div> -->
                                </div>

                                <a href="order_history.php" class="neo-view-link">View All Bookings <i class="fa-solid fa-arrow-right"></i></a>
                            </div>

                        </div>


                        <!-- CHART + TABLE -->
                        <div class="neo-double-grid-layout">

                            <div class="neo-dashboard-panel">
                                <div class="neo-panel-header">
                                    <h3>Neo Select Enrollments Trend</h3>

                                    <select id="enrollmentYear">
                                        <option value="">Current Year</option>
                                    </select>
                                </div>

                                <canvas id="neoEnrollmentChart"></canvas>
                            </div>

                            <div class="neo-dashboard-panel">
                                <div class="neo-panel-header">
                                    <h3>Recent Neo Select Customers</h3>
                                    <a href="customers_list.php">View All</a>
                                </div>

                                <div class="neo-table-wrapper">
                                    <table class="neo-dashboard-table" id="recentCustomersTable">
                                        <thead>
                                            <tr>
                                                <th>Customer</th>
                                                <th>Mobile</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            <tr>
                                                <td colspan="4" class="text-center">
                                                    Loading customers...
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>

                                </div>
                            </div>

                        </div>


                        <!-- 3 GRID -->
                        <div class="neo-triple-grid-layout">
                            <div class="card rounded-4 border-1 p-3 mb-0">
                                <div class="neo-panel-header d-flex justify-content-between align-items-center">
                                    <h3 class="commission-title fs-5 mb-0">
                                        Recent Activities
                                    </h3>
                                    <a href="recent_activities.php" class="fs-6 fw-bold">
                                        View All
                                    </a>
                                </div>
                                <div class="cardDetails" id="recentActivities">
                                </div>
                            </div>
                            <!-- TRANSACTIONS -->
                            <div class="neo-dashboard-panel">
                                <div class="neo-panel-header">
                                    <h3>Commission Transactions</h3>
                                    <a href="holiday_payout.php">View All</a>
                                </div>

                                <div class="neo-table-wrapper">
                                    <table class="neo-dashboard-table" id="commissionTransactionsTable">
                                        <thead>
                                            <tr>
                                                <th>Customer</th>
                                                <th>Date</th>
                                                <th>Membership</th>
                                                <th>Commission</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            <tr>
                                                <td colspan="4" class="text-center">Loading...</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>

                                <div class="neo-total-earned-box">
                                    Total Commission Earned
                                    <strong id="totalCommissionEarned">₹ 0.00</strong>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <?php include_once "ibr_footer.php" ?>
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
        <div class="modal fade" id="staticBackdrop" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel">
            <div class="modal-dialog modal-sm me-4">
                <div class="modal-content rounded-4 border-1">
                    <div class="modal-header border-0">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body text-center">
                        <img src="../assets/images/img-bot.png" alt="image-bot" class="mb-3">
                        <h5 class="fw-bold" id="staticBackdropLabel">
                            Hi, how can we help?
                        </h5>
                        <p class="text-muted px-1">
                            Contact us if you need assistance.
                            We will respond as soon as possible.
                        </p>
                        <div class="d-grid col-10 mx-auto">
                            <a class="btn btn-primary rounded-3" href="tel:8010892265" id="callBtn">
                                <i class="ri-phone-fill"></i>
                                8010892265
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- contact card pop up end-->

        <!-- JAVASCRIPT -->
        <script src="../assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
        <script src="../assets/libs/simplebar/simplebar.min.js"></script>
        <script src="../assets/libs/node-waves/waves.min.js"></script>
        <script src="../assets/libs/feather-icons/feather.min.js"></script>
        <script src="../assets/js/jquery/jquery-3.7.1.min.js"></script>

        <!-- !-- materialdesign remix icon js- -->
        <script src="../assets/js/pages/remix-icons-listing.js"></script>

        <!-- Vector map-->
        <script src="../assets/libs/jsvectormap/js/jsvectormap.min.js"></script>
        <script src="../assets/libs/jsvectormap/maps/world-merc.js"></script>

        <!--Swiper slider js-->
        <script src="../assets/libs/swiper/swiper-bundle.min.js"></script>

        <!-- App js -->
        <script src="../assets/js/app.js"></script>


        <!-- Chart.js 4 CDN -->
        <script src="https://cdn.jsdelivr.net/npm/chart.js@4/dist/chart.umd.min.js"></script>



        <!-- Dashboard init  popular candidates section js file-->

        <script src="../assets/js/js-confetti.js"></script>
        <!-- <script src="../assets/js/ibr_index.js"></script> -->
        <script>
            // =====================================================
            // DASHBOARD TOP CARDS
            // =====================================================

            function loadDashboardCards() {

                $.ajax({
                    url: 'ajax/dashboard/card_data.php',
                    type: 'GET',
                    dataType: 'json',

                    success: function (response) {

                        if (!response.status || !response.data) {
                            console.error(
                                'Dashboard data could not be loaded:',
                                response.message || 'Invalid response'
                            );
                            showDashboardError();
                            return;
                        }

                        const data = response.data;

                        // ==========================================
                        // 1. NEO SELECT ENROLLMENTS
                        // ==========================================

                        const customerCount = Number(data.reg_cu_count) || 0;

                        $('#cuCount').text(
                            customerCount.toLocaleString('en-IN')
                        );
                        $('#userName').text(data.name);

                        // ==========================================
                        // 2. COMMISSION EARNED
                        // ==========================================

                        const activationAmount =
                            Number(data.activation_amount) || 0;

                        const tripAmount =
                            Number(data.trip_amount) || 0;

                        const totalCommission =
                            data.total_comm !== undefined &&
                            data.total_comm !== null &&
                            data.total_comm !== ''
                                ? Number(data.total_comm) || 0
                                : activationAmount + tripAmount;

                        $('#cuComm').text(formatRupees(totalCommission));

                        const averageCommission = customerCount > 0
                            ? activationAmount / customerCount
                            : 0;

                        $('#perCuComm').text(
                            customerCount.toLocaleString('en-IN') +
                            ' Customers × ' +
                            formatRupees(averageCommission)
                        );

                        // ==========================================
                        // 3. PAID AND PENDING COMMISSION
                        // ==========================================

                        const paidCommission =
                            Number(data.paid_commission) || 0;

                        const pendingCommission =
                            data.pending_commission !== undefined &&
                            data.pending_commission !== null &&
                            data.pending_commission !== ''
                                ? Number(data.pending_commission) || 0
                                : Math.max(totalCommission - paidCommission, 0);

                        $('#cuCommPaid').text(formatRupees(paidCommission));
                        $('#cuCommPending').text(formatRupees(pendingCommission));

                        // ==========================================
                        // 4. TOTAL HOLIDAY BOOKINGS
                        // ==========================================

                        const bookingCount = Number(data.booking_count) || 0;

                        $('#bookingCount').text(
                            bookingCount.toLocaleString('en-IN')
                        );

                        // ==========================================
                        // 5. DESTINATION-WISE TRIP COUNTS
                        // ==========================================

                        loadDestinationTrips(data.destinations || []);
                        loadRecentActivities();
                        loadCommissionTransactions()
                    },

                    error: function (xhr, status, error) {

                        console.error('Dashboard AJAX Error:', error);
                        console.error('Response:', xhr.responseText);

                        showDashboardError();
                    }
                });
            }


            // =====================================================
            // DESTINATION-WISE BOOKINGS
            // =====================================================

            function loadDestinationTrips(destinations) {

                const $list = $('.neo-booking-mini-list');

                if (!$list.length) {
                    return;
                }

                $list.empty();

                if (!Array.isArray(destinations) || destinations.length === 0) {

                    const $empty = $('<div>', {
                        class: 'text-muted text-center py-3'
                    });

                    $('<i>', {
                        class: 'ri-map-pin-line me-1'
                    }).appendTo($empty);

                    $empty.append(
                        document.createTextNode('No trips booked yet.')
                    );

                    $list.append($empty);
                    return;
                }

                destinations.forEach(function (item) {

                    const destinationName =
                        String(item.destination || 'Unknown destination');

                    const tripCount = Number(item.trip_count) || 0;

                    const $row = $('<div>', {
                        class: 'neo-booking-mini-item'
                    });

                    const $details = $('<div>', {
                        class: 'neo-booking-mini-details'
                    });

                    $('<i>', {
                        class: 'ri-map-pin-line neo-booking-mini-icon'
                    }).appendTo($details);

                    $('<span>', {
                        class: 'neo-booking-mini-destination',
                        text: destinationName
                    }).appendTo($details);

                    $('<span>', {
                        class: 'neo-booking-mini-count',
                        text: tripCount +
                            (tripCount === 1 ? ' trip' : ' trips')
                    }).appendTo($row);

                    $row.prepend($details);

                    $list.append($row);
                });
            }


            // =====================================================
            // FORMAT INDIAN RUPEE AMOUNTS
            // =====================================================

            function formatRupees(amount) {

                amount = Number(amount) || 0;

                return '₹ ' + amount.toLocaleString('en-IN', {
                    minimumFractionDigits: 0,
                    maximumFractionDigits: 2
                });
            }


            // =====================================================
            // DASHBOARD ERROR FALLBACK
            // =====================================================

            function showDashboardError() {

                $('#cuCount').text('—');
                $('#cuComm').text('—');
                $('#perCuComm').text('Unable to load commission');
                $('#cuCommPaid').text('—');
                $('#cuCommPending').text('—');
                $('#bookingCount').text('—');

                const $list = $('.neo-booking-mini-list');

                if ($list.length) {
                    $list.empty().append(
                        $('<div>', {
                            class: 'text-muted text-center py-3',
                            text: 'Unable to load booking details.'
                        })
                    );
                }
            }
            //recent activities
            function loadRecentActivities() { 
                const $container = $('#recentActivities'); 
                $container.html(` <div class="text-center py-3"> 
                                    <span class="spinner-border spinner-border-sm text-primary">
                                    </span> <span class="ms-2">Loading activities...</span> 
                                    </div> `); 
                $.ajax({ 
                url: 'ajax/dashboard/recent_activities_data.php', 
                type: 'GET', 
                dataType: 'json', 
                success: function (response) { 
                    if ( response.status !== true || !Array.isArray(response.data) || response.data.length === 0 ) { 
                        $container.html(` <div class="text-center text-muted py-4"> 
                                            <i class="fa-regular fa-bell-slash fs-3"></i> 
                                            <p class="mb-0 mt-2">No recent activities found.</p> 
                                        </div> `); 
                        return; 
                    } 
                    let html = ''; 
                    response.data.slice(0, 5).forEach(function (activity) { 
                        const escapeHtml = function (value) { 
                            return String(value ?? '').replace(/[&<>"']/g, function (char) { 
                                return { 
                                    '&': '&amp;', 
                                    '<': '&lt;', 
                                    '>': '&gt;', 
                                    '"': '&quot;', 
                                    "'": '&#039;' 
                                }[char]; 
                            }); }; 
                            const title = escapeHtml(activity.title); 
                            const type = String(activity.type ?? '').toLowerCase(); 
                            const dateValue = activity.date; 
                            let icon = 'fa-user'; 
                            let iconClass = 'activity-default'; 
                            if (type === 'commission') { 
                                icon = 'fa-wallet'; 
                                iconClass = 'activity-commission'; 
                            } else if (type === 'customer_activation') {
                                icon = 'fa-user-check';
                                iconClass = 'activity-activation';

                            } else if (type === 'pending_customer') {
                                icon = 'fa-user-clock';
                                iconClass = 'activity-pending';
                            } else if (type === 'payout') { 
                                icon = 'fa-money-bill-transfer'; 
                                iconClass = 'activity-payout'; 
                            } 
                            let formattedDate = 'Date unavailable'; 
                            if (dateValue) { 
                                const date = new Date( String(dateValue).replace(' ', 'T') ); 
                                if (!isNaN(date.getTime())) { 
                                    formattedDate = date.toLocaleString('en-IN', { 
                                        day: '2-digit', 
                                        month: 'short', 
                                        year: 'numeric', 
                                        hour: '2-digit', 
                                        minute: '2-digit', 
                                        hour12: true }); 
                                    } 
                                } 
                                html += ` <div class="recent-activity-item d-flex align-items-start gap-3 py-3"> 
                                            <div class="activity-icon ${iconClass}"> 
                                                <i class="fa-solid ${icon}"></i> 
                                            </div> 
                                            <div class="flex-grow-1 min-width-0"> 
                                                <p class="activity-description mb-1"> ${title} </p> 
                                                <small class="activity-date"> 
                                                    <i class="fa-regular fa-clock me-1"></i> ${escapeHtml(formattedDate)} 
                                                </small> </div> </div> `; 
                                        }); 
                                $container.html(html); 
                            }, error: function (xhr, status, error) { 
                                console.error('Recent activities error:', error, xhr.responseText); 
                                $container.html(` <div class="text-center text-danger py-4"> 
                                                    <i class="fa-solid fa-triangle-exclamation"></i> 
                                                    <p class="mb-0 mt-2">Unable to load recent activities.</p> 
                                                    </div> `); 
                            } 
                        }); 
            }
            

            function loadCommissionTransactions() {

                const $tbody = $('#commissionTransactionsTable tbody');

                $tbody.html(`
                    <tr>
                        <td colspan="4" class="text-center">Loading transactions...</td>
                    </tr>
                `);

                $.ajax({
                    url: 'ajax/dashboard/get_commission_transactions.php',
                    type: 'GET',
                    dataType: 'json',

                    success: function (response) {

                        if (response.status !== true) {
                            showCommissionMessage('Unable to load transactions.');
                            return;
                        }

                        const transactions = Array.isArray(response.data)
                            ? response.data
                            : [];

                        const total = Number(response.total_commission) || 0;

                        $('#totalCommissionEarned').text(
                            '₹ ' + total.toLocaleString('en-IN', {
                                minimumFractionDigits: 2,
                                maximumFractionDigits: 2
                            })
                        );

                        if (transactions.length === 0) {
                            showCommissionMessage('No commission transactions found.');
                            return;
                        }

                        let rows = '';

                        transactions.forEach(function (item) {

                            const escapeHtml = function (value) {
                                return String(value ?? '').replace(/[&<>"']/g, function (char) {
                                    return {
                                        '&': '&amp;',
                                        '<': '&lt;',
                                        '>': '&gt;',
                                        '"': '&quot;',
                                        "'": '&#039;'
                                    }[char];
                                });
                            };

                            let formattedDate = '—';

                            if (item.date) {
                                const parsedDate = new Date(
                                    String(item.date).replace(' ', 'T')
                                );

                                if (!isNaN(parsedDate.getTime())) {
                                    formattedDate = parsedDate.toLocaleDateString('en-IN', {
                                        day: '2-digit',
                                        month: 'short',
                                        year: 'numeric'
                                    });
                                }
                            }

                            const amount = Number(item.commission) || 0;

                            rows += `
                                <tr>
                                    <td>${escapeHtml(item.customer_name)}</td>
                                    <td>${escapeHtml(formattedDate)}</td>
                                    <td>${escapeHtml(item.membership)}</td>
                                    <td>
                                        <span class="fw-bold text-success">
                                            ₹ ${amount.toLocaleString('en-IN', {
                                                minimumFractionDigits: 2,
                                                maximumFractionDigits: 2
                                            })}
                                        </span>
                                    </td>
                                </tr>
                            `;
                        });

                        $tbody.html(rows);
                    },

                    error: function (xhr, status, error) {

                        console.error(
                            'Commission transactions AJAX error:',
                            error,
                            xhr.responseText
                        );

                        showCommissionMessage('Failed to load commission transactions.');
                    }
                });
            }

            function showCommissionMessage(message) {

                $('#commissionTransactionsTable tbody').html(`
                    <tr>
                        <td colspan="4" class="text-center text-muted">
                            ${$('<div>').text(message).html()}
                        </td>
                    </tr>
                `);
            }


            function loadRecentCustomers() { 
                const $tbody = $('#recentCustomersTable tbody'); 
                $tbody.html(` <tr> <td colspan="4" class="text-center"> Loading customers... </td> </tr> `); 
                $.ajax({ 
                    url: 'ajax/dashboard/recent_cu_list.php', 
                    type: 'GET', 
                    dataType: 'json', 
                    success: function (response) { 
                        if (!response.status || !Array.isArray(response.data)) { 
                            showNoCustomers('Unable to load customers.'); 
                            return; 
                        } 
                        if (response.data.length === 0) { 
                            showNoCustomers('No customers found.'); 
                            return; 
                        } 
                        let rows = ''; 
                        response.data.forEach(function (customer) { 
                            // Escape text before inserting database values into HTML. 
                            const escapeHtml = function (value) { 
                                return String(value ?? '').replace(/[&<>"']/g, function (char) { 
                                    return { '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#039;' }[char]; 
                                }); 
                            }; 
                            const name = escapeHtml(customer.cust_name); 
                            const phone = escapeHtml(customer.phone); 
                            const status = String(customer.status ?? 'Unknown'); 
                            let statusClass = 'neo-status-interest'; 
                            switch (status) { 
                                case 'Active': 
                                    statusClass = 'neo-status-active'; 
                                    break; 
                                case 'Pending': 
                                    statusClass = 'neo-status-pending'; 
                                    break; 
                                case 'Deactive': 
                                case 'Deleted': 
                                case 'Unknown': 
                                    statusClass = 'neo-status-interest'; 
                                    break; 
                            } 
                            const customerId = escapeHtml(customer.ca_customer_id); 
                            const whatsappNumber = String(customer.phone ?? '') .replace(/\D/g, ''); 
                            rows += ` <tr> 
                                        <td>${name}</td> 
                                        <td>${phone}</td> 
                                        <td> <span class="${statusClass}"> ${escapeHtml(status)} </span> </td> 
                                        <td>
                                            <div class="neo-table-actions"> 
                                                <form action="edit_customer.php" method="POST" class="m-0">
                                                    <input
                                                        type="hidden"
                                                        name="id"
                                                        value="${customerId}"
                                                    >
                                                    <input
                                                        type="hidden"
                                                        name="status"
                                                        value="${status}"
                                                    >

                                                    <button
                                                        type="submit"
                                                        class="border-0 bg-transparent p-0"
                                                        title="View Customer"
                                                    >
                                                        <i class="fa-solid fa-eye"
                                                        role="button"
                                                        tabindex="0"
                                                        aria-label="View Customer">
                                                        </i>
                                                    </button>
                                                </form> 
                                                <i class="fa-solid fa-calendar" role="button" tabindex="0" title="View Bookings" data-action="bookings" data-id="${customerId}"> </i> 
                                                <i class="fa-brands fa-whatsapp" role="button" tabindex="0" title="WhatsApp Customer" data-action="whatsapp" data-phone="${escapeHtml(whatsappNumber)}"> </i> 
                                            </div> 
                                        </td> 
                                      </tr> `; 
                                }); 
                                $tbody.html(rows); 
                        }, 
                        error: function (xhr, status, error) { 
                            console.error( 'Recent customers AJAX error:', error, xhr.responseText ); 
                            showNoCustomers('Failed to load customers.'); 
                        } 
                    }); 
                } 
                function showNoCustomers(message) { 
                    $('#recentCustomersTable tbody').html(` <tr> <td colspan="4" class="text-center"> ${$('<div>').text(message).html()} </td> </tr> `); 
                }


            // =====================================================
            // NEO SELECT ENROLLMENT CHART
            // =====================================================

            let enrollmentChart = null;

            $(document).ready(function () {
                // Load dashboard summary cards.
                loadDashboardCards();
                //load ercent customers
                loadRecentCustomers();

                // ==========================================
                // INITIALIZE CHART
                // ==========================================

                const enrollmentCtx = document.getElementById('neoEnrollmentChart');

                if (!enrollmentCtx) {
                    console.log('Canvas #neoEnrollmentChart was not found.');
                    return;
                }

                enrollmentChart = new Chart(enrollmentCtx, {

                    type: 'line',

                    data: {
                        labels: [
                            'Jan', 'Feb', 'Mar', 'Apr',
                            'May', 'Jun', 'Jul', 'Aug',
                            'Sep', 'Oct', 'Nov', 'Dec'
                        ],

                        datasets: [{
                            label: 'Neo Select Enrollments',
                            data: Array(12).fill(0),

                            borderColor: '#1565d8',
                            backgroundColor: 'rgba(21, 101, 216, 0.08)',

                            borderWidth: 3,
                            tension: 0.4,
                            fill: true,

                            pointRadius: 4,
                            pointHoverRadius: 6,
                            pointBackgroundColor: '#1565d8',
                            pointBorderColor: '#ffffff',
                            pointBorderWidth: 2
                        }]
                    },

                    options: {

                        responsive: true,
                        maintainAspectRatio: false,

                        plugins: {

                            legend: {
                                display: true,
                                position: 'top'
                            },

                            tooltip: {
                                callbacks: {
                                    label: function (context) {
                                        return 'Enrollments: ' + context.parsed.y;
                                    }
                                }
                            }
                        },

                        scales: {
                            y: {
                                min: -0.5,
                                max: 5,

                                ticks: {
                                    stepSize: 1,
                                    precision: 0,
                                    autoSkip: false,
                                    color: '#6B7280',

                                    callback: function (value) {
                                        return value < 0 ? '' : value;
                                    }
                                },

                                grid: {
                                    color: '#EEF2F7'
                                },

                                border: {
                                    display: false
                                }
                            },

                            x: {
                                grid: {
                                    display: false
                                },

                                border: {
                                    display: false
                                },

                                ticks: {
                                    color: '#6B7280'
                                }
                            }
                        }
                    }
                });

                // Load enrollment data for the default year.
                loadEnrollmentChart();

                // Reload when the selected year changes.
                $('#enrollmentYear').on('change', function () {
                    loadEnrollmentChart($(this).val());
                });

            });


            // =====================================================
            // LOAD MONTHLY ENROLLMENT DATA
            // =====================================================

            function loadEnrollmentChart(year = '') {
                
                $.ajax({

                    url: 'ajax/dashboard/cust_growth_chart_data.php',
                    type: 'POST',
                    dataType: 'json',

                    data: {
                        year: year
                    },

                    beforeSend: function () {
                        $('#enrollmentChartLoader').show();
                    },

                    success: function (response) {

                        if (!response.status) {
                            console.error(
                                'Enrollment chart error:',
                                response.message || 'Unable to load data'
                            );
                            return;
                        }

                        // Populate available years.
                        populateEnrollmentYears(
                            response.years || [],
                            response.selectedYear
                        );

                        const chartData = (response.data || []).map(function (value) {
                            return Number(value) || 0;
                        });

                        const allZero = chartData.every(function (value) {
                            return value === 0;
                        });

                        if (enrollmentChart) {

                            enrollmentChart.data.labels = response.labels || [];
                            enrollmentChart.data.datasets[0].data = chartData;

                            const allZero = chartData.every(function (value) {
                                return value === 0;
                            });

                            const yAxis = enrollmentChart.options.scales.y;

                            if (allZero) {
                                // Create space below zero so the line doesn't touch the bottom.
                                yAxis.min = -0.5;
                                yAxis.max = 5;

                                yAxis.ticks.stepSize = 1;
                                yAxis.ticks.autoSkip = false;
                            } else {
                                // Automatically scale for actual enrollment values.
                                yAxis.min = -0.03;
                                yAxis.max = undefined;

                                yAxis.ticks.stepSize = undefined;
                                yAxis.ticks.autoSkip = true;
                            }

                            enrollmentChart.update();
                        }
                    },

                    error: function (xhr, status, error) {

                        console.error('Enrollment AJAX error:', error);
                        console.error('Response:', xhr.responseText);
                    },

                    complete: function () {
                        $('#enrollmentChartLoader').hide();
                    }
                });
            }


            // =====================================================
            // POPULATE YEAR DROPDOWN
            // =====================================================

            function populateEnrollmentYears(years, selectedYear) {

                const $yearSelect = $('#enrollmentYear');

                if (!$yearSelect.length) {
                    return;
                }

                const currentValue = String(
                    selectedYear || new Date().getFullYear()
                );

                $yearSelect.empty();

                years.forEach(function (year) {

                    $yearSelect.append(
                        $('<option>', {
                            value: year,
                            text: year
                        })
                    );
                });

                $yearSelect.val(currentValue);
            }

        </script>
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

        <!-- dialer logic -->
    </body>
</html>