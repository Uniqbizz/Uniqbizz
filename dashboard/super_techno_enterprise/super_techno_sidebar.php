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
                    <a class="nav-link menu-link" href="../index.php" role="button" aria-expanded="false" aria-controls="sidebarDashboards">
                        <i class="fa-regular fa-house d-flex"></i> <span data-key="t-dashboards">Dashboards</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu-link" href="../index.php" role="button" aria-expanded="false" aria-controls="sidebarDashboards">
                        <i class="ri-user-shared-2-line"></i> <span data-key="t-home">Techno Enterprisee</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu-link" href="../index.php" role="button" aria-expanded="false" aria-controls="sidebarDashboards">
                        <i class="ri-user-shared-2-line"></i> <span data-key="t-home">Travel Consultants</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu-link" href="../index.php" role="button" aria-expanded="false" aria-controls="sidebarDashboards">
                        <i class="ri-user-shared-2-line"></i> <span data-key="t-home">Customers</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu-link" href="../index.php" role="button" aria-expanded="false" aria-controls="sidebarDashboards">
                        <i class="ri-user-shared-2-line"></i> <span data-key="t-home">Commission</span>
                    </a>
                </li>
                <img src="../assets/images/sidebarImage.png" alt="Package" class="sidebarImage">
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
<!-- Left Sidebar End -->

<!-- vertical-overlay -->
