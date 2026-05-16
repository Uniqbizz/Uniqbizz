<?php
    include_once '../dashboard_user_details.php';
    // include 'customer_model.php';
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
        <!-- App Css-->
        <link href="../assets/css/app.min.css" rel="stylesheet" type="text/css" />
        <!-- custom Css-->
        <link href="../assets/css/custom.min.css" rel="stylesheet" type="text/css" />
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
        <link rel="stylesheet" href="../assets/css/customer_dashboard.css" />
        <link rel="stylesheet" href="../assets/css/ibr_index.css" />
        
    </head>

    <body class="twocolumn-panel">
        <!-- Begin page -->
        <div id="layout-wrapper">
            <?php include_once "customer_header.php" ?>

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

            <?php include_once "customer_sidebar.php" ?>
            <!-- ============================================================== -->
            <!-- Start of Customer Dashboard here -->
            <!-- ============================================================== -->
            <div class="main-content">
                <div class="page-content">
                    <div class="container-fluid ps-0">
                        <div class="neo-main-dashboard-wrapper">

                            <!-- TOP CARDS -->
                            <div class="neo-top-stats-grid">

                                <div class="neo-stat-card neo-blue-card neo-card-watermark neo-blue-watermark">
                                    <div class="neo-stat-card-header">
                                        <div class="neo-stat-icon neo-blue-icon">
                                            <i class="fa-solid fa-id-card"></i>
                                        </div>

                                        <div>
                                            <h4>Neo Select Enrollments</h4>
                                            <h2>48</h2>
                                            <p>This Month</p>
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
                                    <!-- <div class="neo-card-footer-growth">
                                        <span><i class="fa-solid fa-arrow-up"></i> 18%</span>
                                        vs Apr 2024
                                    </div> -->
                                </div>

                                <div class="neo-stat-card neo-green-card neo-card-watermark neo-green-watermark">
                                    <div class="neo-stat-card-header">
                                        <div class="neo-stat-icon neo-green-icon">
                                            <i class="fa-solid fa-sack-dollar"></i>
                                        </div>

                                        <div>
                                            <h4>Commission Earned</h4>
                                            <h2>₹ 24,000</h2>
                                            <p>48 Customers × ₹500</p>
                                        </div>
                                    </div>

                                    <div class="neo-mini-grid-boxes">
                                        <div>
                                            <span>Paid Commission</span>
                                            <strong>₹ 18,000</strong>
                                        </div>

                                        <div>
                                            <span>Pending Payout</span>
                                            <strong>₹ 6,000</strong>
                                        </div>
                                    </div>

                                    <div class="neo-bottom-line-link">
                                        Next Incentive Slab: 50 more to unlock ₹5,000 bonus
                                    </div>
                                </div>

                                <div class="neo-stat-card neo-purple-card neo-card-watermark neo-purple-watermark">
                                    <div class="neo-stat-card-header neo-flex-start">
                                        <div class="neo-stat-icon neo-purple-icon">
                                            <i class="fa-solid fa-gift"></i>
                                        </div>

                                        <div>
                                            <h4>Holiday Bookings</h4>
                                            <h2>18</h2>
                                        </div>
                                    </div>

                                    <div class="neo-booking-mini-list">
                                        <div><span>Goa Packages</span> <strong>12</strong></div>
                                        <div><span>Dubai</span> <strong>4</strong></div>
                                        <div><span>Singapore</span> <strong>2</strong></div>
                                        <div><span>Others</span> <strong>0</strong></div>
                                    </div>

                                    <a href="#" class="neo-view-link">View All Bookings <i class="fa-solid fa-arrow-right"></i></a>
                                </div>

                                <!-- <div class="neo-stat-card neo-orange-card">
                                    <div class="neo-conversion-layout">

                                        <div class="neo-conversion-circle">
                                            <svg>
                                                <circle cx="70" cy="70" r="55"></circle>
                                                <circle cx="70" cy="70" r="55" class="neo-active-circle"></circle>
                                            </svg>
                                            <div class="neo-circle-text">40%</div>
                                        </div>

                                        <div class="neo-conversion-content">
                                            <h4>Conversion Rate</h4>
                                            <div>
                                                <span>Leads Received</span>
                                                <strong>120</strong>
                                            </div>
                                            <div>
                                                <span>Membership Activated</span>
                                                <strong>48</strong>
                                            </div>
                                        </div>
                                    </div>

                                    <a href="#" class="neo-view-link orange">View Conversion Funnel <i class="fa-solid fa-arrow-right"></i></a>
                                </div> -->

                            </div>


                            <!-- CHART + TABLE -->
                            <div class="neo-double-grid-layout">

                                <div class="neo-dashboard-panel">
                                    <div class="neo-panel-header">
                                        <h3>Neo Select Enrollments Trend</h3>

                                        <select>
                                            <option>This Month</option>
                                            <option>Last Month</option>
                                        </select>
                                    </div>

                                    <canvas id="neoEnrollmentChart"></canvas>
                                </div>


                                <div class="neo-dashboard-panel">
                                    <div class="neo-panel-header">
                                        <h3>Recent Neo Select Customers</h3>
                                        <a href="#">View All</a>
                                    </div>

                                    <div class="neo-table-wrapper">
                                        <table class="neo-dashboard-table">
                                            <thead>
                                            <tr>
                                                <th>Customer</th>
                                                <th>Mobile</th>
                                                <th>Branch</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                            </thead>

                                            <tbody>
                                            <tr>
                                                <td>Rahul Naik</td>
                                                <td>98XXXXXX21</td>
                                                <td>Panaji</td>
                                                <td><span class="neo-status-active">Active</span></td>
                                                <td>
                                                    <div class="neo-table-actions">
                                                        <i class="fa-solid fa-eye"></i>
                                                        <i class="fa-solid fa-calendar"></i>
                                                        <i class="fa-brands fa-whatsapp"></i>
                                                    </div>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td>Priya Dessai</td>
                                                <td>99XXXXXX31</td>
                                                <td>Margao</td>
                                                <td><span class="neo-status-active">Active</span></td>
                                                <td>
                                                    <div class="neo-table-actions">
                                                        <i class="fa-solid fa-eye"></i>
                                                        <i class="fa-solid fa-calendar"></i>
                                                        <i class="fa-brands fa-whatsapp"></i>
                                                    </div>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td>Sneha Kamat</td>
                                                <td>96XXXXXX12</td>
                                                <td>Porvorim</td>
                                                <td><span class="neo-status-interest">Interested</span></td>
                                                <td>
                                                    <div class="neo-table-actions">
                                                        <i class="fa-solid fa-eye"></i>
                                                        <i class="fa-solid fa-calendar"></i>
                                                        <i class="fa-brands fa-whatsapp"></i>
                                                    </div>
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                            </div>


                            <!-- 3 GRID -->
                            <div class="neo-triple-grid-layout">

                                <!-- WALLET -->
                                <div class="neo-dashboard-panel">
                                    <div class="neo-wallet-top-box">
                                        <div class="neo-wallet-icon-box">
                                            <i class="fa-solid fa-wallet"></i>
                                        </div>

                                        <div>
                                            <span>Total Wallet Balance</span>
                                            <h2>₹ 24,000</h2>
                                        </div>
                                    </div>

                                    <div class="neo-wallet-mini-grid">
                                        <div>
                                            <span>Available Balance</span>
                                            <strong>₹ 18,000</strong>
                                        </div>

                                        <div>
                                            <span>Pending Balance</span>
                                            <strong>₹ 6,000</strong>
                                        </div>
                                    </div>

                                    <div class="neo-wallet-btn-row">
                                        <button>Withdraw</button>
                                        <button>Transaction History</button>
                                        <button>Incentive Structure</button>
                                    </div>
                                </div>


                                <!-- TRANSACTIONS -->
                                <div class="neo-dashboard-panel">
                                    <div class="neo-panel-header">
                                        <h3>Commission Transactions</h3>
                                        <a href="#">View All</a>
                                    </div>

                                    <div class="neo-table-wrapper">
                                        <table class="neo-dashboard-table">
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
                                                <td>Rahul Naik</td>
                                                <td>15 May 2024</td>
                                                <td>Neo Select</td>
                                                <td>₹ 500</td>
                                            </tr>
                                            <tr>
                                                <td>Priya Dessai</td>
                                                <td>14 May 2024</td>
                                                <td>Neo Select</td>
                                                <td>₹ 500</td>
                                            </tr>
                                            <tr>
                                                <td>Vishal Shet</td>
                                                <td>13 May 2024</td>
                                                <td>Neo Select</td>
                                                <td>₹ 500</td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>

                                    <div class="neo-total-earned-box">
                                        Total Commission Earned
                                        <strong>₹ 24,000</strong>
                                    </div>
                                </div>


                                
                            </div>
                            <!-- BAR CHART -->
                            <!-- <div class="neo-dashboard-panel">
                                <div class="neo-panel-header">
                                    <h3>Holiday Package Interest</h3>

                                    <select>
                                        <option>This Month</option>
                                    </select>
                                </div>

                                <canvas id="neoHolidayChart"></canvas>

                                <div class="neo-chart-footer-link">
                                    <span>12 Neo Select customers booked international holidays this month.</span>
                                    <a href="#">View Bookings <i class="fa-solid fa-angle-right"></i></a>
                                </div>
                            </div> -->


                            <!-- BOTTOM GRID -->
                            <!-- <div class="neo-bottom-grid-layout"> -->

                                <!-- PERFORMANCE -->
                                <!-- <div class="neo-dashboard-panel">

                                    <div class="neo-performance-layout">

                                        <div>
                                            <h3>Performance Target</h3>
                                            <p>Monthly Target: 100 Memberships</p>

                                            <div class="neo-target-count-row">
                                                <h2>48</h2>
                                                <span>/ 100</span>
                                            </div>

                                            <div class="neo-progress-bar">
                                                <div class="neo-progress-fill"></div>
                                            </div>

                                            <div class="neo-progress-footer">
                                                <span>52 more to reach next milestone</span>
                                                <strong>48%</strong>
                                            </div>
                                        </div>

                                        <div class="neo-milestone-box">
                                            <h4>Incentive Milestone</h4>

                                            <div class="neo-milestone-item">
                                                <i class="fa-solid fa-circle-check"></i>
                                                <div>
                                                    <strong>50 Customers</strong>
                                                    <span>₹ 5,000 Bonus</span>
                                                </div>
                                            </div>

                                            <div class="neo-milestone-item">
                                                <i class="fa-solid fa-lock"></i>
                                                <div>
                                                    <strong>100 Customers</strong>
                                                    <span>Goa Incentive Trip</span>
                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                </div> -->


                                <!-- BRANCH PERFORMANCE -->
                                <!-- <div class="neo-dashboard-panel">

                                    <div class="neo-panel-header">
                                        <h3>Branch Performance</h3>

                                        <select>
                                            <option>This Month</option>
                                        </select>
                                    </div>

                                    <div class="neo-branch-grid">

                                        <div class="neo-branch-card">
                                            <span>Total Enrollments</span>
                                            <h2>48</h2>
                                            <div class="neo-rank-row">
                                                <i class="fa-solid fa-trophy"></i>
                                                <div>
                                                    <strong>Rank</strong>
                                                    <p>2 / 8 in Panaji Region</p>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="neo-branch-card green">
                                            <span>Total Commission</span>
                                            <h2>₹ 24,000</h2>
                                            <div class="neo-rank-row">
                                                <i class="fa-solid fa-trophy"></i>
                                                <div>
                                                    <strong>Rank</strong>
                                                    <p>1 / 8 in Panaji Region</p>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div> -->


                                <!-- NOTIFICATIONS -->
                                <!-- <div class="neo-dashboard-panel">

                                    <div class="neo-panel-header">
                                        <h3>Notifications</h3>
                                        <a href="#">View All</a>
                                    </div>

                                    <div class="neo-notification-list">

                                        <div class="neo-notification-item">
                                            <div class="neo-notification-left">
                                                <div class="neo-notify-icon red">
                                                    <i class="fa-solid fa-bell"></i>
                                                </div>

                                                <div>
                                                    <h4>New lead assigned from VPK Camp - Panaji</h4>
                                                    <span>2 min ago</span>
                                                </div>
                                            </div>

                                            <div class="neo-notification-dot red"></div>
                                        </div>

                                        <div class="neo-notification-item">
                                            <div class="neo-notification-left">
                                                <div class="neo-notify-icon green">
                                                    <i class="fa-solid fa-user-check"></i>
                                                </div>

                                                <div>
                                                    <h4>Rahul Naik's membership activated</h4>
                                                    <span>10 min ago</span>
                                                </div>
                                            </div>

                                            <div class="neo-notification-dot green"></div>
                                        </div>

                                    </div>

                                </div> -->

                            <!-- </div> -->


                            <!-- QUICK ACTION -->
                            <div class="neo-quick-action-panel">

                                <h3>Quick Actions</h3>

                                <div class="neo-quick-action-grid">

                                    <button class="neo-action-btn blue">
                                        <i class="fa-solid fa-plus"></i>
                                        Add Customer
                                    </button>

                                    <button class="neo-action-btn green">
                                        <i class="fa-solid fa-circle-check"></i>
                                        Activate Neo Select
                                    </button>

                                    <button class="neo-action-btn purple">
                                        <i class="fa-solid fa-gift"></i>
                                        Create Holiday Inquiry
                                    </button>

                                    <button class="neo-action-btn orange">
                                        <i class="fa-solid fa-wallet"></i>
                                        View Commission
                                    </button>

                                    <button class="neo-action-btn sky">
                                        <i class="fa-solid fa-calendar-days"></i>
                                        Schedule Follow-up
                                    </button>

                                </div>

                            </div>

                        </div>

                    </div>
                </div>
                <?php include_once "customer_footer.php" ?>
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
                        <img src="assets/images/img-bot.png" alt="image-bot" class="mb-3">
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

        <script src="../assets/libs/chart.js/Chart-2.5.0.min.js"></script>


        <!-- Dashboard init  popular candidates section js file-->
        <script src="../assets/js/pages/dashboard-job.init.js"></script>

        <script src="../assets/js/js-confetti.js"></script>
        <script src="../assets/js/ibr_index.js"></script>

        <script>
            var userType= document.getElementById("user_type").value;
            function highlightSelected(id) {
                // Remove highlight from all list items
                document.querySelectorAll("li[id^='list-item-']").forEach(function(el) {
                    el.classList.remove("selected-li");
                });

                // Add highlight to the selected one
                const selected = document.getElementById(id);
                if (selected) {
                    selected.classList.add("selected-li");
                }
            }
        </script>
        
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
        <script>
            // Get values directly from HTML
            const completed = parseInt(document.getElementById("completedYears").innerText);
            const total = parseInt(document.getElementById("totalYears").innerText);

            // Calculate percentage
            const percentage = (completed / total) * 100;

            // Update progress bar
            document.getElementById("yearProgressBar").style.width = percentage + "%";
        </script>

        <!-- dialer logic -->
    </body>
</html>