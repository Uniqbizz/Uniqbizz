<?php
    include_once '../dashboard_user_details.php';
?>
<!doctype html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg" data-sidebar-image="none" data-preloader="disable">
    <head>
        <meta charset="utf-8" />
        <title>Sponsor Franchisee Dashboard | Uniqbizz</title>
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
        <!-- App Css-->
        <link href="../assets/css/app.min.css" rel="stylesheet" type="text/css" />
        <!-- custom Css-->
        <link href="../assets/css/custom.min.css" rel="stylesheet" type="text/css" />
        <!-- custom Css developer-->
        <link rel="stylesheet" href="../assets/css/custom.css" />
        <!-- Super Techno Enterprisee Dashboard CSS -->
        <link rel="stylesheet" href="../assets/css/sponsor_franchisee_dashboard.css" />
        
        <!-- FontAwesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        
    </head>
    <body class="twocolumn-panel">
        <!-- Begin page -->
        <div id="layout-wrapper">
            <?php include_once "sponsor_franchisee_header.php" ?>

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

            <?php include_once "sponsor_franchisee_sidebar.php" ?>
            <!-- ============================================================== -->
            <!-- Start of Super Techno Enterprisee Dashboard here -->
            <!-- ============================================================== -->
            <div class="main-content">
                <div class="page-content">
                    <div class="container-fluid ps-0">
                        <!-- Super Techno Enterprisee Dashboard Greeting Card -->
                        <div class="card mb-0 border rounded-4 shadow-sm overflow-hidden">
                            <div class="greetingImageWrapper">
                                <img src="../assets/images/superTechnoImage.png" alt="Package" class="greetingImage img-fluid w-100">
                            </div>
                            <div class="greetingCard">
                                <p class="fw-bold text-dark gap-3 fs-4">Welcome Back,<span class="" id="userName"></span>! &#128075;</p>
                                <h1 class="fw-bold text-dark gap-3">Sponsor Franchisee</h1>
                                <p class="text-dark fs-4 mb-0">You're building something great.</p>
                                <p class="text-dark fs-4">Here's your business overview.</p>
                            </div>
                        </div>
                        <!-- Card section 2 -->
                        <div class="row">
                            <div class="col-lg-4 col-md-4 col-sm-6 col-12 mt-3">
                                <div class="card mb-0 rounded-4 p-3 stCard5">
                                    <div class="d-flex gap-3">
                                        <div class="stIcon stIcon5">
                                            <i class="fa-solid fa-user-group fa-xl"></i>
                                        </div>
                                        <div class="">
                                            <p class="mb-1 fs-6 fw-bold">Total Franchisee</p>
                                            <h4 class="fw-bolder text-dark mb-1" id="fCount">0</h4>
                                            <a href="techno_enterprise_list.php" class="mb-1 fs-6 fw-bold">View All <i class="fa-solid fa-arrow-right"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-6 col-12 mt-3">
                                <div class="card mb-0 rounded-4 p-3 stCard6">
                                    <div class="d-flex gap-3">
                                        <div class="stIcon stIcon6">
                                            <i class="fa-solid fa-user-group fa-xl"></i>
                                        </div>
                                        <div class="">
                                            <p class="mb-1 fs-6 fw-bold">Total Institute</p>
                                            <h4 class="fw-bolder text-dark mb-1" id="iCount">0</h4>
                                            <a href="#" class="mb-1 fs-6 fw-bold">View All <i class="fa-solid fa-arrow-right"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-6 col-12 mt-3">
                                <div class="card mb-0 rounded-4 p-3 stCard1">
                                    <div class="d-flex gap-3">
                                        <div class="stIcon stIcon1">
                                            <i class="fa-solid fa-user-group fa-xl"></i>
                                        </div>
                                        <div class="">
                                            <p class="mb-1 fs-6 fw-bold">Total Travel Consultant</p>
                                            <h4 class="fw-bolder text-dark mb-1" id="tcCount">0</h4>
                                            <a href="#" class="mb-1 fs-6 fw-bold">View All <i class="fa-solid fa-arrow-right"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-6 col-12 mt-3">
                                <div class="card mb-0 rounded-4 p-3 stCard2">
                                    <div class="d-flex gap-3">
                                        <div class="stIcon stIcon2">
                                            <i class="fa-solid fa-user-group fa-xl"></i>
                                        </div>
                                        <div class="">
                                            <p class="mb-1 fs-6 fw-bold">Total Institute Branch Manager</p>
                                            <h4 class="fw-bolder text-dark mb-1" id="ibrCount">0</h4>
                                            <a href="travel_consultants_list.php" class="mb-1 fs-6 fw-bold">View All <i class="fa-solid fa-arrow-right"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-6 col-12 mt-3">
                                <div class="card mb-0 rounded-4 p-3 stCard3">
                                    <div class="d-flex gap-3">
                                        <div class="stIcon stIcon3">
                                            <i class="fa-solid fa-user-group fa-xl"></i>
                                        </div>
                                        <div class="">
                                            <p class="mb-1 fs-6 fw-bold">Total Customer</p>
                                            <h4 class="fw-bolder text-dark mb-1" id="cuCount">0</h4>
                                            <a href="customers_list.php" class="mb-1 fs-6 fw-bold">View All <i class="fa-solid fa-arrow-right"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-6 col-12 mt-3">
                                <div class="card mb-0 rounded-4 p-3 stCard4">
                                    <div class="d-flex gap-3">
                                        <div class="stIcon stIcon4">
                                            <i class="fa-solid fa-wallet fa-xl"></i>
                                        </div>
                                        <div class="">
                                            <p class="mb-1 fs-6 fw-bold">Total Commission</p>
                                            <h4 class="fw-bolder text-dark mb-1" id="total_com">&#8377; 0</h4>
                                            <a href="holiday_payout.php" class="mb-1 fs-6 fw-bold">View All <i class="fa-solid fa-arrow-right"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Card section 3 -->
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-12 col-12 mt-3">
                                <div class="commission-card px-2">
                                    <div class="card-title d-flex justify-content-between p-2">
                                        <p class="commission-title fs-5">Overall Commission Earned</p>
                                        <p class="">
                                            <select class="form-select yearSelect py-1" id="pyearFilter">
                                                
                                            </select>
                                        </p>
                                    </div>
                                    <div class="commission-wrapper gap-2">
                                        <div class="chart-container">
                                            <canvas id="commissionChart"></canvas>
                                            <div class="center-text">
                                                <p>Total Earnings</p>
                                                <h2 id="paidEarnings">₹ 0</h2>
                                            </div>
                                        </div>
                                        <div class="legend-section-details">
                                            <div class="legend-section">
                                                <div class="legend-item">
                                                    <div class="legend-left">
                                                        <span class="dot" style="background:#5B2EFF"></span>
                                                        <span>Recruitment Commission</span>
                                                    </div>
                                                    <div class="d-flex gap-3 recruitmentMargin">
                                                        <div class="amount" id="recruitmentAmount"> &#8377; 100000</div>
                                                        <div class="percent" id="recruitmentPercent">55%</div>
                                                    </div>
                                                </div>
                                                <div class="legend-item">
                                                    <div class="legend-left">
                                                        <span class="dot" style="background:#2563EB"></span>
                                                        <span>Holiday account activation Commission</span>
                                                    </div>
                                                    <div class="d-flex gap-3 recruitmentMargin">
                                                        <div class="amount" id="neoAmount"> &#8377; 100000</div>
                                                        <div class="percent" id="neoPercent">55%</div>
                                                    </div>
                                                </div>
                                                <div class="legend-item">
                                                    <div class="legend-left">
                                                        <span class="dot" style="background:#00C46A"></span>
                                                        <span>Tour Booking Commission</span>
                                                    </div>
                                                    <div class="d-flex gap-3 recruitmentMargin">
                                                        <div class="amount" id="bookingAmount"> &#8377; 0</div>
                                                        <div class="percent" id="bookingPercent">0%</div>
                                                    </div>
                                                </div>
                                                <!-- <div class="report-link">
                                                    <a href="#">
                                                        View Commission Report →
                                                    </a>
                                                </div> -->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12 col-12 mt-3">
                                <div class="commission-card px-2">
                                    <div class="commission-title">
                                        My Wallet
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-6 col-md-12 col-sm-6 col-12">
                                            <div class="card rounded-4 p-3 stWalletCard1">
                                                <div class="d-flex justify-content-between">
                                                    <div class="">
                                                        <p class="mb-1 fs-6 fw-bold">Paid Earnings</p>
                                                        <h4 class="fw-bolder text-dark mb-1" id="total_paid_earning">&#8377; 9,18,000</h4>
                                                    </div>
                                                    <div class="stWalletIcon1">
                                                        <i class="fa-solid fa-wallet"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-12 col-sm-6 col-12">
                                            <div class="card rounded-4 p-3 stWalletCard2">
                                                <div class="d-flex justify-content-between">
                                                    <div class="">
                                                        <p class="mb-1 fs-6 fw-bold">Pending Earnings</p>
                                                        <h4 class="fw-bolder text-dark mb-1" id="total_pending_earning">&#8377; 45,000</h4>
                                                    </div>
                                                    <div class="stWalletIcon2">
                                                        <i class="fa-regular fa-hourglass"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- <div class="row d-flex justify-content-center">
                                        <div class="col-lg-5">
                                            <a href="#">
                                                <div class="stWalletBtn">
                                                    <p class="fs-5 mb-0 fw-bolder">Withdraw <i class="fa-solid fa-arrow-right"></i></p>
                                                </div>
                                            </a>
                                        </div>
                                    </div> -->
                                </div>
                            </div>
                        </div>
                        <!-- Card section 4 -->
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-12 col-12 mt-3">
                                <div class="cardChart mb-0 card border-1">
                                    <div class="card-title d-flex justify-content-between p-2">
                                        <p class="commission-title fs-5">Customer Count (Yearly)</p>
                                        <p class="">
                                            <select class="form-select yearSelect py-1" id="yearFilter">
                                                
                                            </select>
                                        </p>
                                    </div>
                                    <div class="card-body">
                                        <canvas id="customerTrendChart"></canvas>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12 col-12 mt-3">
                                <div class="cardChart mb-0 card border-1">
                                    <div class="card-title d-flex justify-content-between p-2">
                                        <p class="commission-title fs-5">TE | F | I Enrollment Count (Yearly)</p>
                                        <p class="">
                                            <select class="form-select yearSelect py-1" id="enrollmentYearFilter">
                                            </select>
                                        </p>
                                    </div>
                                    <div class="card-body">
                                        <canvas id="enrollmentTrendChart"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Card section 5 -->
                        <div class="row">
                            <div class="col-lg-5 col-sm-12 col-12 mt-3">
                                <div class="card mb-0 rounded-4 border-1 p-3 h-100">
                                    <div class="card-title d-flex justify-content-between align-items-center">
                                        <p class="commission-title fs-5 mb-0">
                                            Recent Activities
                                        </p>
                                        <!-- 
                                        <a href="#" class="fs-6 fw-bold">
                                            View All
                                        </a> -->
                                    </div>
                                    <div class="cardDetails mt-3" id="recentActivitiesContainer">
                                        <div class="text-center py-4">
                                            Loading...
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-7 col-sm-12 col-12 mt-3">
                                <div class="card mb-0 rounded-4 border-1 p-3">
                                    <div class="card-title d-flex justify-content-start">
                                        <p class="commission-title fs-5 mb-1">
                                            TE | I Performance
                                        </p>
                                    </div>
                                    <div class="cardDetails">
                                        <table class="table">
                                            <thead>
                                                <tr class="table-active">
                                                    <th scope="col">TE|I Name</th>
                                                    <th scope="col">No. of TC/IBR</th>
                                                    <th scope="col">Neo Select Members</th>
                                                </tr>
                                            </thead>
                                            <tbody id="tePerformanceBody">
                                                
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- card section 6 -->
                        <div class="supportImagePosition mt-3">
                            <img src="../assets/images/supportImage.png" alt="Referral Image" class="supportImage">
                            <div class="supportDetails">
                                <h3 class="text-white fw-bolder fs-2">Need Help Planning?</h3>
                                <p class="text-white fw-normal fs-5">Our travel experts are here for you.</p>
                                <a href="#" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                                    <div class="supportBtn">
                                        <p class="fs-5 mb-0 fw-bolder">Contact Support</p>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <?php include_once "sponsor_franchisee_footer.php" ?>
            </div>

            <!-- end main content-->
            <!-- End of Super Techno Enterprisee Dashboard here -->
            <!-- ============================================================== -->
        </div>
        <!--start back-to-top-->
        <button onclick="topFunction()" class="scrollToTop scroll-btn show btn" id="back-to-top">
            <i class="ri-arrow-up-line"></i>
        </button>
        <?php include (__DIR__.'/../contact_modal.php') ?>
        <!--end back-to-top-->
        <!-- contact card pop up  start-->
        <button type="button" class="contactBtn btn" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
            <i class="ri-phone-fill"></i>
        </button>
        

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
        <!-- Chart -->
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <!-- <script src="../assets/libs/chart.js/Chart-2.5.0.min.js"></script> -->


        <!-- Dashboard init  popular candidates section js file-->
        <!-- <script src="../assets/js/pages/dashboard-job.init.js"></script> -->

        <script src="../assets/js/js-confetti.js"></script>
        <script>
            function highlightSelected(id) {
                // Remove highlight from all items
                document.querySelectorAll('li[id^="list-item-"]').forEach(function(el) {
                    el.classList.remove('active-highlight');
                });

                // Add highlight to the clicked item
                const selectedItem = document.getElementById(id);
                if (selectedItem) {
                    selectedItem.classList.add('active-highlight');
                }
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
        <script>
            document.addEventListener("DOMContentLoaded", function () {

                const sidebar = document.querySelector(".navbar-menu");
                const hamburger = document.getElementById("topnav-hamburger-icon");
                const overlay = document.querySelector(".vertical-overlay");

                /* DEFAULT DESKTOP */
                if (window.innerWidth > 1024) {
                    sidebar.classList.remove("sidebar-hidden");
                }

                hamburger.addEventListener("click", function () {

                    /* BELOW 1024 */
                    if (window.innerWidth <= 1024) {

                        sidebar.classList.toggle("sidebar-mobile-show");

                        /* OVERLAY ONLY BELOW 768 */
                        if (window.innerWidth <= 768) {
                            overlay.classList.toggle("active");
                        }

                    } else {

                        /* DESKTOP */
                        sidebar.classList.toggle("sidebar-hidden");
                    }
                });

                /* CLOSE ONLY MOBILE */
                if (window.innerWidth <= 768) {

                    overlay.addEventListener("click", function () {

                        sidebar.classList.remove("sidebar-mobile-show");
                        overlay.classList.remove("active");

                    });
                }

            });

        </script>
       
        <!-- dialer logic -->
        <!-- Card section 3 -->
        <script>
            
            let commissionChart = null;
            let customerTrendChart;
            function loadYearDropdown() {

                const currentYear = new Date().getFullYear();
                const startYear = 2023; // change if required

                let options = '';

                for (let year = currentYear; year >= startYear; year--) {

                    options += `
                        <option value="${year}" ${year === currentYear ? 'selected' : ''}>
                            ${year}
                        </option>
                    `;

                }

                $('#pyearFilter').html(options);

            }

            loadYearDropdown();
            function loadCommissionChart() {

                let selectedYear = $('#pyearFilter').val();

                $.ajax({

                    url: 'models/dashboard/ste_com_piechart_data.php',
                    type: 'POST',
                    dataType: 'json',

                    data: {
                        selectedYear: selectedYear
                    },

                    success: function (res) {

                        if (!res.status) {

                            return;

                        }

                        const recruitmentAmount = Number(res.data.recruitment.amount || 0);
                        const neoAmount = Number(res.data.neo_select.amount || 0);
                        const bookingAmount = Number(res.data.booking.amount || 0);

                        const totalEarnings = Number(res.data.total_earnings || 0);

                        $('#recruitmentAmount').text('₹' + recruitmentAmount.toLocaleString('en-IN'));
                        $('#neoAmount').text('₹' + neoAmount.toLocaleString('en-IN'));
                        $('#bookingAmount').text('₹' + bookingAmount.toLocaleString('en-IN'));
                        $('#paidEarnings').text('₹' + totalEarnings.toLocaleString('en-IN'));

                        const recruitmentPercent = Number(res.data.recruitment.percentage || 0);
                        const neoPercent = Number(res.data.neo_select.percentage || 0);
                        const bookingPercent = Number(res.data.booking.percentage || 0);

                        $('#recruitmentPercent').text(recruitmentPercent.toFixed(1) + '%');
                        $('#neoPercent').text(neoPercent.toFixed(1) + '%');
                        $('#bookingPercent').text(bookingPercent.toFixed(1) + '%');

                        if (totalEarnings > 0) {

                            $('.center-text p').text('Total Earnings');

                        } else {

                            $('.center-text p').text('No Earnings Yet');

                        }

                        if (commissionChart) {

                            if (totalEarnings == 0) {

                                commissionChart.data.datasets[0].data = [100];

                                commissionChart.data.datasets[0].backgroundColor = [
                                    '#E5E7EB'
                                ];

                            } else {

                                commissionChart.data.datasets[0].data = [
                                    recruitmentPercent,
                                    neoPercent,
                                    bookingPercent
                                ];

                                commissionChart.data.datasets[0].backgroundColor = [
                                    '#5B2EFF',
                                    '#2563EB',
                                    '#00C46A'
                                ];

                            }

                            commissionChart.update();

                        }

                    },

                    error: function () {

                        console.log('Unable to load chart.');

                    }

                });

            }
            function initializeCustomerTrendChart() {

                const months = [
                    'Jan','Feb','Mar','Apr','May','Jun',
                    'Jul','Aug','Sep','Oct','Nov','Dec'
                ];

                customerTrendChart = new Chart(
                    document.getElementById('customerTrendChart'),
                    {
                        type: 'line',
                        data: {
                            labels: months,
                            datasets: [{
                                label: 'Customers',
                                data: Array(12).fill(0),
                                borderColor: '#2F6BFF',
                                backgroundColor: function(context) {

                                    const chart = context.chart;
                                    const ctx = chart.ctx;
                                    const chartArea = chart.chartArea;

                                    if (!chartArea) {
                                        return null;
                                    }

                                    const gradient = ctx.createLinearGradient(
                                        0,
                                        chartArea.top,
                                        0,
                                        chartArea.bottom
                                    );

                                    gradient.addColorStop(
                                        0,
                                        'rgba(47,107,255,0.30)'
                                    );

                                    gradient.addColorStop(
                                        1,
                                        'rgba(47,107,255,0.02)'
                                    );

                                    return gradient;
                                },
                                fill: true,
                                tension: 0.4,
                                pointRadius: 4,
                                pointHoverRadius: 6,
                                pointBackgroundColor: '#2F6BFF'
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                legend: {
                                    display: false
                                }
                            },
                            scales: {
                                x: {
                                    grid: {
                                        display: false
                                    }
                                },
                                y: {
                                    beginAtZero: true,
                                    grid: {
                                        color: '#edf1f7'
                                    }
                                }
                            }
                        }
                    }
                );

            }
            let yearsLoaded = false;

            function loadCustomerTrendChart(year = '') {

                $.ajax({
                    url: 'models/dashboard/ste_cust_line_chart_data.php',
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        year: year
                    },
                    success: function(res) {

                        if (!res.status) {
                            return;
                        }

                        /*
                        |--------------------------------------------------------------------------
                        | Load Years Only Once
                        |--------------------------------------------------------------------------
                        */

                        if (!yearsLoaded) {

                            let options = '';

                            $.each(res.data.years, function(i, year) {

                                options += `
                                    <option value="${year}">
                                        ${year}
                                    </option>
                                `;

                            });

                            $('#yearFilter').html(options);

                            $('#yearFilter').val(
                                res.data.selected_year
                            );

                            yearsLoaded = true;
                        }

                        /*
                        |--------------------------------------------------------------------------
                        | Chart Data
                        |--------------------------------------------------------------------------
                        */

                        let chartData = Array(12).fill(0);

                        $.each(res.data.customer_trend, function(index, item) {

                            let monthIndex = parseInt(item.month) - 1;

                            chartData[monthIndex] = parseInt(item.total) || 0;

                        });

                        customerTrendChart.data.datasets[0].data =
                            chartData;

                        customerTrendChart.update();

                    }
                });

            }
            function loadCommissionChart() {

                const selectedYear = $('#pyearFilter').val();

                $.ajax({

                    url: 'models/dashboard/ste_com_piechart_data.php',

                    type: 'POST',

                    dataType: 'json',

                    data: {
                        selectedYear: selectedYear
                    },

                    success: function (res) {

                        // console.log(res);

                        if (!res.status) return;

                        const recruitmentAmount = Number(res.data.recruitment.amount || 0);
                        const neoAmount = Number(res.data.neo_select.amount || 0);
                        const bookingAmount = Number(res.data.booking.amount || 0);

                        const recruitmentPercent = Number(res.data.recruitment.percentage || 0);
                        const neoPercent = Number(res.data.neo_select.percentage || 0);
                        const bookingPercent = Number(res.data.booking.percentage || 0);

                        const totalEarnings = Number(res.data.total_earnings || 0);

                        $('#recruitmentAmount').text('₹' + recruitmentAmount.toLocaleString('en-IN'));
                        $('#neoAmount').text('₹' + neoAmount.toLocaleString('en-IN'));
                        $('#bookingAmount').text('₹' + bookingAmount.toLocaleString('en-IN'));
                        $('#paidEarnings').text('₹' + totalEarnings.toLocaleString('en-IN'));

                        $('#recruitmentPercent').text(recruitmentPercent.toFixed(1) + '%');
                        $('#neoPercent').text(neoPercent.toFixed(1) + '%');
                        $('#bookingPercent').text(bookingPercent.toFixed(1) + '%');

                        $('.center-text p').text(
                            totalEarnings > 0 ? 'Total Earnings' : 'No Earnings Yet'
                        );

                        if (!commissionChart) return;

                        commissionChart.data.labels = [
                            'Recruitment',
                            'Holiday Activation',
                            'Tour Booking'
                        ];

                        if (totalEarnings > 0) {

                            commissionChart.data.datasets[0].data = [
                                recruitmentAmount,
                                neoAmount,
                                bookingAmount
                            ];

                            commissionChart.data.datasets[0].backgroundColor = [
                                '#5B2EFF',
                                '#2563EB',
                                '#00C46A'
                            ];

                        } else {

                            commissionChart.data.datasets[0].data = [100];

                            commissionChart.data.datasets[0].backgroundColor = [
                                '#E5E7EB'
                            ];

                        }

                        commissionChart.update();

                    },

                    error: function (xhr) {

                        // console.log(xhr.responseText);

                    }

                });

            }
            function initializeChart() {

                const canvas = document.getElementById('commissionChart');

                if (!canvas) {
                    return;
                }

                const ctx = canvas.getContext('2d');

                // Destroy existing chart if any
                if (commissionChart) {
                    commissionChart.destroy();
                }

                commissionChart = new Chart(ctx, {
                    type: 'doughnut',
                    data: {
                        labels: [
                            'Recruitment Commission',
                            'Neo Select Commission',
                            'Booking Commission'
                        ],
                        datasets: [{
                            data: [1],
                            backgroundColor: ['#E5E7EB'],
                            borderWidth: 3,
                            borderColor: '#fff'
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        cutout: '70%',
                        plugins: {
                            legend: {
                                display: false
                            }
                        }
                    }
                });
            }

            function loadData() {

                /*
                |--------------------------------------------------------------------------
                | User & Dashboard Counts
                |--------------------------------------------------------------------------
                */

                $.when(

                    $.ajax({
                        url: 'models/dashboard/ste_model.php',
                        type: 'POST',
                        dataType: 'json'
                    }),

                    $.ajax({
                        url: 'models/dashboard/ste_dash_card_data.php',
                        type: 'POST',
                        dataType: 'json'
                    })

                ).done(function (userRes, dashRes) {

                    const user = userRes[0];
                    const dash = dashRes[0];

                    if (user.status && user.data) {

                        $('#userName').text(
                            (user.data.firstname || '') +
                            ' ' +
                            (user.data.lastname || '')
                        );

                    }

                    if (dash.status && dash.data) {

                        $('#fCount').text(dash.data.f_count || 0);
                        $('#iCount').text(dash.data.i_count || 0);
                        $('#ibrCount').text(dash.data.ibr_count || 0);
                        $('#tcCount').text(dash.data.tc_count || 0);
                        $('#cuCount').text(dash.data.cu_count || 0);
                        $('#total_com').text('\u20B9' + (dash.data.all_earning || 0));
                        $('#total_paid_earning').text('\u20B9' + (dash.data.all_paid_earning || 0));
                        $('#total_pending_earning').text('\u20B9' + (dash.data.all_pending_earning || 0));

                    }

                }).fail(function (xhr, status, error) {

                    console.error('Dashboard Error:', error);

                });


                /*
                |--------------------------------------------------------------------------
                | Commission Chart Data
                |--------------------------------------------------------------------------
                */
                loadYearDropdown();
                loadCommissionChart();

            }

            let enrollmentTrendChart;
            let enrollmentYearsLoaded = false;

            function initializeEnrollmentTrendChart() {

                const months = [
                    'Jan','Feb','Mar','Apr','May','Jun',
                    'Jul','Aug','Sep','Oct','Nov','Dec'
                ];

                const ctx = document.getElementById('enrollmentTrendChart');

                enrollmentTrendChart = new Chart(ctx, {

                    type: 'line',

                    data: {

                        labels: months,

                        datasets: [

                                {
                                    label: 'TE',
                                    data: Array(12).fill(0),
                                    borderColor: '#1DB56C',
                                    backgroundColor: '#1DB56C',
                                    backgroundColor: function(context) {

                                        const chart = context.chart;
                                        const ctx = chart.ctx;
                                        const chartArea = chart.chartArea;

                                        if (!chartArea) {
                                            return null;
                                        }

                                        const gradient = ctx.createLinearGradient(
                                            0,
                                            chartArea.top,
                                            0,
                                            chartArea.bottom
                                        );

                                        gradient.addColorStop(
                                            0,
                                            'rgba(47, 255, 64, 0.3)'
                                        );

                                        gradient.addColorStop(
                                            1,
                                            'rgba(47, 255, 71, 0.02)'
                                        );

                                        return gradient;
                                    },
                                    fill: true,
                                    tension: 0.4,
                                    pointRadius: 4,
                                    pointHoverRadius: 6,
                                    pointBackgroundColor: '#1DB56C'
                                },
                                {
                                    label: 'F',
                                    data: Array(12).fill(0),
                                    borderColor: '#2435f2',
                                    backgroundColor: '#0e199b',
                                    backgroundColor: function(context) {

                                        const chart = context.chart;
                                        const ctx = chart.ctx;
                                        const chartArea = chart.chartArea;

                                        if (!chartArea) {
                                            return null;
                                        }

                                        const gradient = ctx.createLinearGradient(
                                            0,
                                            chartArea.top,
                                            0,
                                            chartArea.bottom
                                        );

                                        gradient.addColorStop(
                                            0,
                                            'rgba(47, 57, 255, 0.3)'
                                        );

                                        gradient.addColorStop(
                                            1,
                                            'rgba(255, 241, 47, 0.02)'
                                        );

                                        return gradient;
                                    },
                                    fill: true,
                                    tension: 0.4,
                                    pointRadius: 4,
                                    pointHoverRadius: 6,
                                    pointBackgroundColor: '#0e199b'
                                },
                                {
                                    label: 'I',
                                    data: Array(12).fill(0),
                                    borderColor: '#f6ea3b',
                                    backgroundColor: '#eaf63b',
                                    backgroundColor: function(context) {

                                        const chart = context.chart;
                                        const ctx = chart.ctx;
                                        const chartArea = chart.chartArea;

                                        if (!chartArea) {
                                            return null;
                                        }

                                        const gradient = ctx.createLinearGradient(
                                            0,
                                            chartArea.top,
                                            0,
                                            chartArea.bottom
                                        );

                                        gradient.addColorStop(
                                            0,
                                            'rgba(255, 241, 47, 0.3)'
                                        );

                                        gradient.addColorStop(
                                            1,
                                            'rgba(255, 241, 47, 0.02)'
                                        );

                                        return gradient;
                                    },
                                    fill: true,
                                    tension: 0.4,
                                    pointRadius: 4,
                                    pointHoverRadius: 6,
                                    pointBackgroundColor: '#eaf63b'
                                }

                            ]
                    },

                    options: {

                        responsive: true,
                        maintainAspectRatio: false,

                        plugins: {
                            legend: {
                                display: true
                            }
                        },

                        scales: {

                            x: {
                                grid: {
                                    display: false
                                }
                            },

                            y: {
                                beginAtZero: true,
                                grid: {
                                    color: '#edf1f7'
                                }
                            }

                        }

                    }

                });
            }
            function loadEnrollmentTrendChart(year = '') {

                $.ajax({

                    url: 'models/dashboard/ste_te_line_chart_data.php',

                    type: 'POST',

                    dataType: 'json',

                    data: {
                        year: year
                    },

                    success: function(res) {

                        if (!res.status) {
                            return;
                        }

                        /*
                        |--------------------------------------------------------------------------
                        | Populate Year Dropdown
                        |--------------------------------------------------------------------------
                        */

                        if (!enrollmentYearsLoaded) {

                            let options = '';

                            $.each(res.data.years, function(i, year) {

                                options += `
                                    <option value="${year}">
                                        ${year}
                                    </option>
                                `;

                            });

                            $('#enrollmentYearFilter')
                                .html(options)
                                .val(res.data.selected_year);

                            enrollmentYearsLoaded = true;
                        }

                        /*
                        |--------------------------------------------------------------------------
                        | TE Data
                        |--------------------------------------------------------------------------
                        */

                        let teData = Array(12).fill(0);

                        $.each(res.data.te_trend, function(i, row) {

                            let monthIndex =
                                parseInt(row.month_no) - 1;

                            teData[monthIndex] =
                                parseInt(row.te_count) || 0;

                        });

                        /*
                        |--------------------------------------------------------------------------
                        | I Data
                        |--------------------------------------------------------------------------
                        */

                        let iData = Array(12).fill(0);

                        $.each(res.data.i_trend, function(i, row) {

                            let monthIndex =
                                parseInt(row.month_no) - 1;

                            iData[monthIndex] =
                                parseInt(row.i_count) || 0;

                        });

                        /*
                        |--------------------------------------------------------------------------
                        | Update Chart
                        |--------------------------------------------------------------------------
                        */

                        enrollmentTrendChart.data.datasets[0].data = teData;
                        enrollmentTrendChart.data.datasets[1].data = iData;

                        enrollmentTrendChart.update();

                    },

                    error: function(xhr, status, error) {

                        console.error('Chart Load Error:', error);
                        console.log(xhr.responseText);

                    }

                });

            }
            function loadTEPerformance() {

                $.ajax({
                    url: 'models/dashboard/ste_te_performance_data.php',
                    type: 'POST',
                    dataType: 'json',

                    success: function(res) {

                        if (!res.status) {
                            return;
                        }

                        let html = '';

                        if (res.data.length === 0) {

                            html = `
                                <tr>
                                    <td colspan="3" class="text-center py-4">
                                        No data found
                                    </td>
                                </tr>
                            `;

                        } else {

                            $.each(res.data, function(index, row) {
                                let badge = '';

                                if (
                                    row.te_id.startsWith('TE') ||
                                    row.te_id.startsWith('CA')
                                ) {
                                    badge = '<span class="badge bg-primary ms-1">TE</span>';
                                } else if (
                                    row.te_id.startsWith('F')
                                ) {
                                    badge = '<span class="badge bg-success ms-1">F</span>';
                                } else if (
                                    row.te_id.startsWith('I')
                                ) {
                                    badge = '<span class="badge bg-info ms-1">I</span>';
                                }
                                html += `
                                    <tr>
                                        <th scope="row">
                                            ${badge} ${row.te_name} 
                                        </th>

                                        <td class="text-center">
                                            ${row.tc_count}
                                        </td>

                                        <td class="text-center">
                                            ${row.cu_count}
                                        </td>
                                    </tr>
                                `;

                            });

                        }

                        $('#tePerformanceBody').html(html);

                    },

                    error: function(xhr, status, error) {

                        console.error(
                            'TE Performance Error:',
                            error
                        );

                    }

                });

            }
            function loadRecentActivities() {

                $.ajax({
                    url: 'models/dashboard/ste_recent_activity_data.php',
                    type: 'POST',
                    dataType: 'json',

                    success: function(res) {

                        if (!res.status) {
                            return;
                        }

                        let html = '';

                        $.each(res.data, function(index, row) {

                            let iconClass = 'stRecentIcon1';
                            let icon = 'fa-user-group';
                            let textClass = 'text-muted';

                            if (row.type === 'customer') {

                                iconClass = 'stRecentIcon2';
                                icon = 'fa-user-group';

                            } else if (row.type === 'recruitment') {

                                iconClass = 'stRecentIcon4';
                                icon = 'fa-indian-rupee-sign';
                                textClass = 'text-success';

                            } else if (row.type === 'booking') {

                                iconClass = 'stRecentIcon5';
                                icon = 'fa-indian-rupee-sign';
                                textClass = 'text-success';

                            }

                            let activityDate = new Date(row.date).toLocaleDateString('en-IN', {
                                day: 'numeric',
                                month: 'short',
                                year: 'numeric'
                            });
                            let activityTime = new Date(row.date).toLocaleTimeString(
                                'en-IN',
                                {
                                    hour: '2-digit',
                                    minute: '2-digit'
                                }
                            );

                            html += `
                                <div class="d-flex justify-content-between mb-3">

                                    <div class="d-flex gap-2">

                                        <div class="stRecentIcon ${iconClass}">
                                            <i class="fa-solid ${icon} fa-xl"></i>
                                        </div>

                                        <div>

                                            <p class="mb-1 fs-6 fw-bold">
                                                ${row.title}
                                            </p>

                                            <p class="mb-0 fs-6 ${textClass}">
                                                ${row.description}
                                            </p>

                                        </div>

                                    </div>

                                    <p class="text-muted mb-0 text-nowrap text-end">
                                        ${activityDate}</br>
                                        ${activityTime}
                                    </p>

                                </div>
                            `;
                        });

                        if (html === '') {

                            html = `
                                <div class="text-center py-5">

                                    <i class="fa-solid fa-clock-rotate-left fa-3x text-muted mb-3"></i>

                                    <p class="text-muted mb-0">
                                        No Recent Activities Found
                                    </p>

                                </div>
                            `;
                        }

                        $('#recentActivitiesContainer').html(html);

                    }
                });
            }
            $(document).on(
                'change',
                '#enrollmentYearFilter',
                function() {

                    loadEnrollmentTrendChart(
                        $(this).val()
                    );

                }
            );
            $('#pyearFilter').on('change', function () {

                loadCommissionChart();

            });
            $(document).on(
                'change',
                '#yearFilter',
                function() {

                    loadCustomerTrendChart(
                        $(this).val()
                    );

                }
            );
            $(document).ready(function() {

                initializeChart();

                initializeCustomerTrendChart();

                loadData();

                loadCustomerTrendChart();
                
                initializeEnrollmentTrendChart();

                loadEnrollmentTrendChart();

                loadTEPerformance();

                loadRecentActivities();

            });
        </script>
    </body>
</html>