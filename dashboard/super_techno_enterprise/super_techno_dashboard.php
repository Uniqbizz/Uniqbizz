<?php
    include_once '../dashboard_user_details.php';
?>
<!doctype html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg" data-sidebar-image="none" data-preloader="disable">
    <head>
        <meta charset="utf-8" />
        <title>Super Techno Enterprisee Dashboard | Uniqbizz</title>
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
        <link rel="stylesheet" href="../assets/css/super_techno_enterprise.css" />
        
        <!-- FontAwesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        
    </head>
    <body class="twocolumn-panel">
        <!-- Begin page -->
        <div id="layout-wrapper">
            <?php include_once "super_techno_header.php" ?>

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

            <?php include_once "super_techno_sidebar.php" ?>
            <!-- ============================================================== -->
            <!-- Start of Super Techno Enterprisee Dashboard here -->
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
                                <p class="fw-bold text-dark gap-3 fs-4">Welcome Back,<span class="">Sachin</span>! &#128075;</p>
                                <h1 class="fw-bold text-dark gap-3">Super Techno Enterprise</h1>
                                <p class="text-dark fs-4 mb-0">You're building something great.</p>
                                <p class="text-dark fs-4">Here's your business overview.</p>
                            </div>
                        </div>
                        <!-- Card section 2 -->
                        <div class="row">
                            <div class="col-lg-3 col-md-3 col-sm-6 col-12">
                                <div class="card rounded-4 p-3 stCard1">
                                    <div class="d-flex gap-3">
                                        <div class="stIcon stIcon1">
                                            <i class="fa-solid fa-user-group fa-xl"></i>
                                        </div>
                                        <div class="">
                                            <p class="mb-1 fs-6 fw-bold">Techno Enterprises</p>
                                            <h4 class="fw-bolder text-dark mb-1">18</h4>
                                            <a href="#" class="mb-1 fs-6 fw-bold">View All <i class="fa-solid fa-arrow-right"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-3 col-sm-6 col-12">
                                <div class="card rounded-4 p-3 stCard2">
                                    <div class="d-flex gap-3">
                                        <div class="stIcon stIcon2">
                                            <i class="fa-solid fa-user-group fa-xl"></i>
                                        </div>
                                        <div class="">
                                            <p class="mb-1 fs-6 fw-bold">Travel Consultants</p>
                                            <h4 class="fw-bolder text-dark mb-1">142</h4>
                                            <a href="#" class="mb-1 fs-6 fw-bold">View All <i class="fa-solid fa-arrow-right"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-3 col-sm-6 col-12">
                                <div class="card rounded-4 p-3 stCard3">
                                    <div class="d-flex gap-3">
                                        <div class="stIcon stIcon3">
                                            <i class="fa-solid fa-user-group fa-xl"></i>
                                        </div>
                                        <div class="">
                                            <p class="mb-1 fs-6 fw-bold">Customers</p>
                                            <h4 class="fw-bolder text-dark mb-1">680</h4>
                                            <a href="#" class="mb-1 fs-6 fw-bold">View All <i class="fa-solid fa-arrow-right"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-3 col-sm-6 col-12">
                                <div class="card rounded-4 p-3 stCard4">
                                    <div class="d-flex gap-3">
                                        <div class="stIcon stIcon4">
                                            <i class="fa-solid fa-wallet fa-xl"></i>
                                        </div>
                                        <div class="">
                                            <p class="mb-1 fs-6 fw-bold">Total Earnings</p>
                                            <h4 class="fw-bolder text-dark mb-1">&#8377; 9,63,000</h4>
                                            <a href="#" class="mb-1 fs-6 fw-bold">View All <i class="fa-solid fa-arrow-right"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Card section 3 -->
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                                <div class="commission-card px-2">
                                    <div class="commission-title">
                                        Commission Earned This Month
                                    </div>
                                    <div class="commission-wrapper gap-2">
                                        <div class="chart-container">
                                            <canvas id="commissionChart"></canvas>
                                            <div class="center-text">
                                                <p>Total Earnings</p>
                                                <h2>₹ 9,63,000</h2>
                                            </div>
                                        </div>
                                        <div class="legend-section-details">
                                            <div class="legend-section">
                                                <div class="legend-item">
                                                    <div class="legend-left">
                                                        <span class="dot" style="background:#5B2EFF"></span>
                                                        <span>Recruitment Commission</span>
                                                    </div>
                                                    <div class="amount">₹ 4,50,000</div>
                                                    <div class="percent">46.7%</div>
                                                </div>
                                                <div class="legend-item">
                                                    <div class="legend-left">
                                                        <span class="dot" style="background:#2563EB"></span>
                                                        <span>Neo Select Commission</span>
                                                    </div>
                                                    <div class="amount">₹ 1,92,000</div>
                                                    <div class="percent">19.9%</div>
                                                </div>
                                                <div class="legend-item">
                                                    <div class="legend-left">
                                                        <span class="dot" style="background:#00C46A"></span>
                                                        <span>Booking Commission</span>
                                                    </div>
                                                    <div class="amount">₹ 3,21,000</div>
                                                    <div class="percent">33.4%</div>
                                                </div>
                                                <div class="report-link">
                                                    <a href="#">
                                                        View Commission Report →
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                                <div class="commission-card px-2">
                                    <div class="commission-title">
                                        My Wallet
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-6 col-md-12 col-sm-6 col-12">
                                            <div class="card rounded-4 p-3 stWalletCard1">
                                                <div class="d-flex justify-content-between">
                                                    <div class="">
                                                        <p class="mb-1 fs-6 fw-bold">Available Balance</p>
                                                        <h4 class="fw-bolder text-dark mb-1">&#8377; 9,18,000</h4>
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
                                                        <p class="mb-1 fs-6 fw-bold">Pending Payout</p>
                                                        <h4 class="fw-bolder text-dark mb-1">&#8377; 45,000</h4>
                                                    </div>
                                                    <div class="stWalletIcon2">
                                                        <i class="fa-regular fa-hourglass"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row d-flex justify-content-center">
                                        <div class="col-lg-5">
                                            <a href="#">
                                                <div class="stWalletBtn">
                                                    <p class="fs-5 mb-0 fw-bolder">Withdraw <i class="fa-solid fa-arrow-right"></i></p>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- card section 8 -->
                        <div class="supportImagePosition mt-3">
                            <img src="../assets/images/supportImage.png" alt="Referral Image" class="supportImage">
                            <div class="supportDetails">
                                <h3 class="text-white fw-bolder fs-2">Need Help Planning?</h3>
                                <p class="text-white fw-normal fs-5">Our travel experts are here for you.</p>
                                <a href="#">
                                    <div class="supportBtn">
                                        <p class="fs-5 mb-0 fw-bolder">Contact Support</p>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <?php include_once "super_techno_footer.php" ?>
            </div>

            <!-- end main content-->
            <!-- End of Super Techno Enterprisee Dashboard here -->
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
        <!-- Chart -->
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <!-- <script src="../assets/libs/chart.js/Chart-2.5.0.min.js"></script> -->


        <!-- Dashboard init  popular candidates section js file-->
        <script src="../assets/js/pages/dashboard-job.init.js"></script>

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
        <script>
            function toggleWishlist(button) {

                button.classList.toggle("active");

                const icon = button.querySelector("i");

                if (button.classList.contains("active")) {
                    icon.classList.remove("fa-regular");
                    icon.classList.add("fa-solid");
                } else {
                    icon.classList.remove("fa-solid");
                    icon.classList.add("fa-regular");
                }
            }
        </script>
        <!-- dialer logic -->
        <!-- Card section 3 -->
        <script>
            const ctx = document.getElementById('commissionChart');

            new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: ['Recruitment', 'Neo Select', 'Booking'],
                    datasets: [{
                        data: [46.7, 19.9, 33.4],
                        backgroundColor: [
                            '#5B2EFF',
                            '#2563EB',
                            '#00C46A'
                        ],
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
        </script>
    </body>
</html>