            <div class="app-menu navbar-menu" style="position: fixed; background: #2a3042 !important;">
                <!-- LOGO -->
                <div class="navbar-brand-box">
                    <!-- Light Logo-->
                    <a href="index.php" class="logo logo-light">
                        <span class="logo-sm">
                            <img src="assets/images/fav.png" alt="" height="25">
                        </span>
                        <span class="logo-lg">
                            <img src="assets/images/logos.png" alt="" height="50">
                        </span>
                    </a>
                    <button type="button" class="btn btn-sm p-0 fs-20 header-item float-end btn-vertical-sm-hover" id="vertical-hover">
                        <i class="ri-record-circle-line"></i>
                    </button>
                </div>
                <!-- logo for mobile view  -->
                <div class="com_logo">
                    <a href="index.php" class="logo logo-light">
                        <span class="logo-sm">
                            <img src="assets/images/logos.png" alt="" height="50">
                        </span>
                    </a>
                </div>
                <!-- sidebar -->
                <div id="scrollbar" >
                    <div class="container-fluid">

                        <div id="two-column-menu">
                        </div>
                        <ul class="navbar-nav" id="navbar-nav" >
                            <li class="menu-title active"><span data-key="t-menu">Menu</span></li>
                            <li class="nav-item">
                                <a class="nav-link menu-link" href="../index.php" role="button" aria-expanded="false" aria-controls="sidebarDashboards">
                                    <i class="ri-layout-masonry-line"></i> <span data-key="t-dashboards">Dashboards</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link menu-link" href="#sidebarEmployees" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarEmployees">
                                    <i class="ri-contacts-line"></i> <span data-key="t-multi-level">Employees</span>
                                </a>
                                <div class="collapse menu-dropdown" id="sidebarEmployees">
                                    <ul class="nav nav-sm flex-column">
                                        <li class="nav-item">
                                            <a href="../employee/view_regional_manager.php" class="nav-link" data-key="t-level-1.1"> Regional Manager</a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="../employee/view_franchisee_manager.php" class="nav-link" data-key="t-level-1.1"> Franchisee Manager </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="../employee/view_floor_manager.php" class="nav-link" data-key="t-level-1.1"> Floor Manager </a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            <!-- <li class="nav-item">
                                <a class="nav-link menu-link" href="../business_trainee/view_business_trainee.php" role="button" aria-expanded="false" aria-controls="sidebarDashboards">
                                    <i class="ri-contacts-line"></i> <span data-key="t-business-trainee">Business Trainee</span>
                                </a>
                            </li> -->
                            <li class="nav-item">
                                <a class="nav-link menu-link" href="../channel_business_director/view_cbd.php" role="button" aria-expanded="false" aria-controls="sidebarDashboards">
                                    <i class="ri-contacts-line"></i> <span data-key="t-channel_business_director">Channel Business Director</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link menu-link" href="../business_consultant/view_business_consultant.php" role="button" aria-expanded="false" aria-controls="sidebarDashboards">
                                    <i class="ri-contacts-line"></i> <span data-key="t-business-consultant">Business Consultant</span>
                                </a>
                            </li>
                            
                            <li class="nav-item">
                                <a class="nav-link menu-link" href="../corporate_agency/view_corporate_agency.php" role="button" aria-expanded="false" aria-controls="sidebarDashboards">
                                    <i class="ri-contacts-line"></i> <span data-key="t-corporate-agency">Corporate Agency</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link menu-link" href="../ca_travelAgency/view_ca_travelAgency.php" role="button" aria-expanded="false" aria-controls="sidebarDashboards">
                                    <i class="ri-contacts-line"></i> <span data-key="t-travel-agent">Travel Agent</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link menu-link" href="../ca_customers/view_customers.php" role="button" aria-expanded="false" aria-controls="sidebarDashboards">
                                    <i class="ri-contacts-line"></i> <span data-key="t-customer">Customer</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link menu-link" href="#sidebarMultilevel" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarMultilevel">
                                    <i class="mdi mdi-share-variant-outline"></i> <span data-key="t-multi-level">Payout</span>
                                </a>
                                <div class="collapse menu-dropdown" id="sidebarMultilevel">
                                    <ul class="nav nav-sm flex-column">
                                        <li class="nav-item">
                                            <a href="../payout/contracting_payout.php" class="nav-link" data-key="t-level-1.1"> Contracting Payout</a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="../payout/recruitment_payout.php" class="nav-link" data-key="t-level-1.1"> Recruitment Payout </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="../payout/product_payout.php" class="nav-link" data-key="t-level-1.1"> Product Payout </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="../payout/cbd_payout.php" class="nav-link" data-key="t-level-1.1"> CBD recruitment </a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link menu-link" href="../packages/all_packages.php" role="button" aria-expanded="false" aria-controls="sidebarDashboards">
                                    <i class="ri-contacts-line"></i> <span data-key="t-customer">Packages</span>
                                </a>
                            </li>

                            <!-- <li class="nav-item">
                                <a class="nav-link menu-link" href="#sidebarMultilevel" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarMultilevel">
                                    <i class="mdi mdi-share-variant-outline"></i> <span data-key="t-multi-level">Multi Level</span>
                                </a>
                                <div class="collapse menu-dropdown" id="sidebarMultilevel">
                                    <ul class="nav nav-sm flex-column">
                                        <li class="nav-item">
                                            <a href="#" class="nav-link" data-key="t-level-1.1"> Level 1.1 </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="#sidebarAccount" class="nav-link" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarAccount" data-key="t-level-1.2"> Level 1.2
                                            </a>
                                            <div class="collapse menu-dropdown" id="sidebarAccount">
                                                <ul class="nav nav-sm flex-column">
                                                    <li class="nav-item">
                                                        <a href="#" class="nav-link" data-key="t-level-2.1"> Level 2.1 </a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a href="#sidebarCrm" class="nav-link" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarCrm" data-key="t-level-2.2"> Level 2.2
                                                        </a>
                                                        <div class="collapse menu-dropdown" id="sidebarCrm">
                                                            <ul class="nav nav-sm flex-column">
                                                                <li class="nav-item">
                                                                    <a href="#" class="nav-link" data-key="t-level-3.1"> Level 3.1 </a>
                                                                </li>
                                                                <li class="nav-item">
                                                                    <a href="#" class="nav-link" data-key="t-level-3.2"> Level 3.2 </a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </li>
                                                </ul>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </li> -->

                        </ul>
                    </div>
                    <!-- Sidebar -->
                </div>

                <div class="sidebar-background"></div>
            </div>
            <!-- Left Sidebar End -->
            
            <!-- vertical-overlay -->
            <div class="vertical-overlay"></div>
