<!-- modal css -->
<link rel="stylesheet" href="assets/css/my_consultant_modal.css" />
<div class="app-menu navbar-menu rounded-4 bg-white" style="position: fixed; margin-top: 80px !important; width: 240px; padding-top: 0px !important; padding-bottom: 0px !important; margin-bottom: 10px !important;">
    <!-- LOGO -->
    <div class="navbar-brand-box">
        
        <button type="button" class="btn btn-sm p-0 fs-20 header-item float-end btn-vertical-sm-hover" id="vertical-hover">
            <i class="ri-record-circle-line"></i>
        </button>
    </div>
    
    <!-- sidebar -->
    <div id="scrollbar" >
        <div class="container-fluid">

            <div id="two-column-menu">
            </div>
            <ul class="navbar-nav" id="navbar-nav" >
                <li class="menu-title"><span data-key="t-menu">Menu</span></li>
                <li class="nav-item active">
                    <a class="nav-link menu-link" href="customer_dashboard.php" role="button" aria-expanded="false" aria-controls="sidebarDashboards">
                        <i class="fa-regular fa-house d-flex"></i> <span data-key="t-dashboards">Dashboards</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu-link" href="../../tour-list.php" role="button" aria-expanded="false" aria-controls="sidebarDashboards">
                        <i class="ri-briefcase-4-line"></i> <span data-key="t-home">Explore Packages</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu-link" href="order_history.php" role="button" aria-expanded="false" aria-controls="sidebarDashboards">
                        <i class="ri-calendar-check-line"></i> <span data-key="t-home">My Bookings</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu-link" href="order_history.php#user_table1_length" role="button" aria-expanded="false" aria-controls="sidebarDashboards">
                        <i class="ri-wallet-line"></i> <span data-key="t-home">Upcoming Trips</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu-link" href="customer_wallet.php" role="button" aria-expanded="false" aria-controls="sidebarDashboards">
                        <i class="ri-wallet-line"></i> <span data-key="t-home">Wallet</span>
                    </a>
                </li>
                <!-- <li class="nav-item">
                    <a class="nav-link menu-link" href="../#" role="button" aria-expanded="false" aria-controls="sidebarDashboards">
                        <i class="ri-gift-line"></i> <span data-key="t-home">Rewards & Coupons</span>
                    </a>
                </li> -->
                <li class="nav-item">
                    <a class="nav-link menu-link" href="customer_benefit.php" role="button" aria-expanded="false" aria-controls="sidebarDashboards">
                        <i class="ri-vip-crown-2-line"></i> <span data-key="t-home">Neo Select Memberships</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu-link" href="view_customer.php" role="button" aria-expanded="false" aria-controls="sidebarDashboards">
                        <i class="ri-group-line"></i> <span data-key="t-home">Refer & Earn</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu-link"
                    href="javascript:void(0)"
                    id="qxz9OpenConsultantModal"
                    role="button">

                        <i class="ri-user-shared-2-line"></i>

                        <span data-key="t-home">
                            My Consultant
                        </span>

                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu-link" href="#" role="button" aria-expanded="false" aria-controls="sidebarDashboards">
                        <i class="ri-customer-service-2-line"></i> <span data-key="t-home">Support</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu-link" href="#">
                        <i class="ri-settings-3-line"></i><span>Settings</span>
                    </a>
                </li>
                <img src="assets/images/sidebarImage.png" alt="Package" class="sidebarImage">
                <div class="exploreCard">
                    <h3 class="fw-bold text-white">Dream. <br> <span class="text-warning">Explore.</span> <br> <span class="text-warning">Discover.</span></h3>
                    <p class="text-white">Your next adventure is just a click away.</p>
                    <a href="../../tour-list.php">
                        <div class="exploreBtn">
                            <p class="fs-5 mb-0 fw-bolder">Explore Packages</p>
                            <i class="ri-arrow-right-line d-flex align-items-center"></i>
                        </div>
                    </a>
                </div>
                <li class="nav-item <?php echo ($first_part=="../logout.php") ? "active" : ""; ?>">
                    <a class="logoutBtn mylogout" href="../logout.php">
                        <i class="mdi mdi-logout d-flex justify-content-start align-items-center me-3"></i>
                        <span class="fs-5 mb-0 fw-bolder" data-key="t-logout">Logout</span>
                    </a>
                </li>
            </ul>
        </div>
        <!-- Sidebar -->
    </div>

    <div class="sidebar-background"></div>
</div>
<?php include 'my_consultant_modal.php' ?>
<script>
document.addEventListener("DOMContentLoaded", function () {

    const qxz9Modal =
    document.getElementById('qxz9ConsultantModal');

    const qxz9OpenBtn =
    document.getElementById('qxz9OpenConsultantModal');

    const qxz9CloseBtn =
    document.getElementById('qxz9CloseConsultantModal');

    // Safety check
    if (!qxz9Modal || !qxz9OpenBtn || !qxz9CloseBtn) {
        console.log("Modal elements not found");
        return;
    }

    /* OPEN */
    qxz9OpenBtn.addEventListener('click', function () {
        qxz9Modal.classList.add('active');
    });

    /* CLOSE */
    qxz9CloseBtn.addEventListener('click', function () {
        qxz9Modal.classList.remove('active');
    });

    /* OUTSIDE CLICK CLOSE */
    qxz9Modal.addEventListener('click', function (e) {
        if (e.target === qxz9Modal) {
            qxz9Modal.classList.remove('active');
        }
    });

});
</script>
<!-- Left Sidebar End -->

<!-- vertical-overlay -->
