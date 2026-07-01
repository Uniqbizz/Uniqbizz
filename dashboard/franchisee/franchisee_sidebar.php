<?php
    $current_page = basename($_SERVER['PHP_SELF']);
?>
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
                <li class="nav-item <?php echo ($current_page == 'techno_dashboard.php') ? 'active' : ''; ?>">
                    <a class="nav-link menu-link" href="techno_dashboard.php">
                        <i class="fa-regular fa-house d-flex"></i><span>Dashboards</span>
                    </a>
                </li>
                <!-- <li class="nav-item <?php //echo ($current_page == 'techno_enterprise_list.php') ? 'active' : ''; ?>">
                    <a class="nav-link menu-link" href="techno_enterprise_list.php">
                        <i class="ri-user-shared-2-line"></i> <span>TE / F</span>
                    </a>
                </li> -->
                <li class="nav-item <?php echo ($current_page == 'travel_consultants_list.php') ? 'active' : ''; ?>">
                    <a class="nav-link menu-link" href="travel_consultants_list.php">
                        <i class="ri-user-shared-2-line"></i> <span data-key="t-home">Travel Consultants</span>
                    </a>
                </li>
                <li class="nav-item <?php echo ($current_page == 'customers_list.php') ? 'active' : ''; ?>">
                    <a class="nav-link menu-link" href="customers_list.php">
                        <i class="ri-user-shared-2-line"></i> <span data-key="t-home">Customers</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu-link" href="#sidebarMultilevel" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarMultilevel">
                        <i class="ri-user-shared-2-line"></i> <span data-key="t-home">Commission</span>
                    </a>
                    <div class="collapse menu-dropdown" id="sidebarMultilevel">
                        <ul class="nav nav-sm flex-column">
                            <!-- <li class="nav-item <?php //echo ($current_page == 'contracting_payout.php') ? 'active' : ''; ?>">
                                <a href="contracting_payout.php" class="nav-link menu-link">
                                    <span data-key="recruitment-payout">TE Contracting Payout</span>
                                </a>
                            </li>
                            <li class="nav-item <?php //echo ($current_page == 'sub_franchisee_payout.php') ? 'active' : ''; ?>">
                                <a href="sub_franchisee_payout.php" class="nav-link menu-link">
                                    <span data-key="recruitment-payout">Franchisee Contracting Payout</span>
                                </a>
                            </li> -->
                            <!-- <li class="nav-item <?php //echo ($current_page == 'recruitment_payout.php') ? 'active' : ''; ?>">
                                <a href="recruitment_payout.php" class="nav-link menu-link">
                                    <span data-key="recruitment-payout">TC Recruitment Payout</span>
                                </a>
                            </li> -->
                            <li class="nav-item <?php echo ($current_page == 'holiday_payout.php') ? 'active' : ''; ?>">
                                <a href="holiday_payout.php" class="nav-link menu-link">
                                    <span data-key="holiday-payout">Holiday Account Payout</span>
                                </a>
                            </li>
                            <li class="nav-item <?php echo ($current_page == 'product_payout.php') ? 'active' : ''; ?>">
                                <a href="product_payout.php" class="nav-link menu-link">
                                    <span data-key="product-payout">Product Payout</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item <?php echo ($current_page == 'order_history.php') ? 'active' : ''; ?>">
                    <a class="nav-link menu-link" href="order_history.php">
                        <i class="ri-user-shared-2-line"></i> <span data-key="t-home">Tour History</span>
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
