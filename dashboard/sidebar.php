    <div class="app-menu navbar-menu rounded-4 bg-white" style="position: fixed; margin-top: 80px !important; width: 240px; padding-top: 0px !important">
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
                    <li class="nav-item <?php if ($first_part=="index.php") {echo "actives"; } else  {echo "noactive";}?>">
                        <a class="nav-link menu-link" href="index.php" role="button" aria-expanded="false" aria-controls="sidebarDashboards">
                            <i class="ri-layout-masonry-line"></i> <span data-key="t-dashboards">Dashboards</span>
                        </a>
                    </li>
                    <?php 
                        if($userType == "3"){ ?>
                            <!-- <li class="nav-item <?php if ($first_part=="view_business_trainee.php") {echo "actives"; } else  {echo "noactive";}?>">
                                <a class="nav-link menu-link" href="view_business_trainee.php" role="button" aria-expanded="false" aria-controls="sidebarDashboards">
                                    <i class="ri-contacts-line"></i> <span data-key="t-business-trainee">Business Trainee</span>
                                </a>
                            </li> -->
                            <li class="nav-item <?php if ($first_part=="view_corporate_agency.php") {echo "actives"; } else  {echo "noactive";}?>">
                                <a class="nav-link menu-link" href="view_corporate_agency.php" role="button" aria-expanded="false" aria-controls="sidebarDashboards">
                                    <i class="ri-contacts-line"></i> <span data-key="t-corporate-agency">Corporate Agency</span>
                                </a>
                            </li>
                            <li class="nav-item <?php if ($first_part=="view_travel_agent.php") {echo "actives"; } else  {echo "noactive";}?>">
                                <a class="nav-link menu-link" href="view_travel_agent.php" role="button" aria-expanded="false" aria-controls="sidebarDashboards">
                                    <i class="ri-contacts-line"></i> <span data-key="t-travel-agent">Travel Consultant</span>
                                </a>
                            </li>
                            <li class="nav-item <?php if ($first_part=="view_customer.php") {echo "actives"; } else  {echo "noactive";}?>">
                                <a class="nav-link menu-link" href="view_customer.php" role="button" aria-expanded="false" aria-controls="sidebarDashboards">
                                    <i class="ri-contacts-line"></i> <span data-key="t-customer">Customer</span>
                                </a>
                            </li>
                    <?php
                        }else if($userType == "16"){
                    ?>
                        <li class="nav-item <?php if ($first_part=="../index.php") {echo "actives"; } else  {echo "noactive";}?>">
                            <a class="nav-link menu-link" href="../index.php" role="button" aria-expanded="false" aria-controls="sidebarDashboards">
                                <i class="ri-contacts-line"></i> <span data-key="t-home">Home Page</span>
                            </a>
                        </li>
                        <li class="nav-item <?php if ($first_part=="view_travel_agent.php") {echo "actives"; } else  {echo "noactive";}?>">
                            <a class="nav-link menu-link" href="view_travel_agent.php" role="button" aria-expanded="false" aria-controls="sidebarDashboards">
                                <i class="ri-contacts-line"></i> <span data-key="t-travel-agent">Travel Consultant</span>
                            </a>
                        </li>
                        <li class="nav-item <?php if ($first_part=="view_customer.php") {echo "actives"; } else  {echo "noactive";}?>">
                            <a class="nav-link menu-link" href="view_customer.php" role="button" aria-expanded="false" aria-controls="sidebarDashboards">
                                <i class="ri-contacts-line"></i> <span data-key="t-customer">Customer</span>
                            </a>
                        </li>
                         <li class="nav-item <?php if ($first_part=="markup.php") {echo "actives"; } else  {echo "noactive";}?>">
                            <a class="nav-link menu-link" href="markup.php" role="button" aria-expanded="false" aria-controls="sidebarDashboards">
                                <i class="ri-contacts-line"></i> <span data-key="t-customer">Packages</span>
                            </a>
                        </li>
                        <li class="nav-item <?php if ($first_part=="tour_history.php") {echo "actives"; } else  {echo "noactive";}?>">
                            <a class="nav-link menu-link" href="tour_history.php" role="button" aria-expanded="false" aria-controls="sidebarDashboards">
                                <i class="ri-contacts-line"></i> <span data-key="t-markup">Tour Transaction History</span>
                            </a>
                        </li>
                    <?php  
                        }else if($userType == "11"){
                    ?>
                        <li class="nav-item <?php if ($first_part=="../index.php") {echo "actives"; } else  {echo "noactive";}?>">
                            <a class="nav-link menu-link" href="../index.php" role="button" aria-expanded="false" aria-controls="sidebarDashboards">
                                <i class="ri-contacts-line"></i> <span data-key="t-home">Home Page</span>
                            </a>
                        </li>
                        <li class="nav-item <?php if ($first_part=="markup.php") {echo "actives"; } else  {echo "noactive";}?>">
                            <a class="nav-link menu-link" href="markup.php" role="button" aria-expanded="false" aria-controls="sidebarDashboards">
                                <i class="ri-contacts-line"></i> <span data-key="t-markup">Markup</span>
                            </a>
                        </li>
                        <li class="nav-item <?php if ($first_part=="tour_history.php") {echo "actives"; } else  {echo "noactive";}?>">
                            <a class="nav-link menu-link" href="tour_history.php" role="button" aria-expanded="false" aria-controls="sidebarDashboards">
                                <i class="ri-contacts-line"></i> <span data-key="t-markup">Tour Transaction History</span>
                            </a>
                        </li>
                        <li class="nav-item <?php if ($first_part=="view_customer.php") {echo "actives"; } else  {echo "noactive";}?>">
                            <a class="nav-link menu-link" href="view_customer.php" role="button" aria-expanded="false" aria-controls="sidebarDashboards">
                                <i class="ri-contacts-line"></i> <span data-key="t-customer">Customer</span>
                            </a>
                        </li>
                    <?php  
                        }else if($userType == "10"){
                    ?>
                        <li class="nav-item <?php if ($first_part=="view_customer.php") {echo "actives"; } else  {echo "noactive";}?>">
                            <a class="nav-link menu-link" href="view_customer.php" role="button" aria-expanded="false" aria-controls="sidebarDashboards">
                                <i class="ri-contacts-line"></i> <span data-key="t-customer">Customer</span>
                            </a>
                        </li>
                    <?php } ?>   

                    <?php  
                         if($userType != "18" && $userType != "19"){
                    ?>
                        <li class="nav-item">  <!--payout -->
                            <a class="nav-link menu-link" href="#sidebarMultilevel" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarMultilevel">
                                <i class="mdi mdi-share-variant-outline"></i> <span data-key="t-multi-level">Payouts</span>
                            </a>
                            <div class="collapse menu-dropdown" id="sidebarMultilevel">
                                <ul class="nav nav-sm flex-column">
                                    <?php 
                                        if($userType == "26" || $userType == "25" || $userType == "24" || $userType == "16" || $userType == "11" || $userType == "10"){ 
                                    ?>
                                        <li class="nav-item  <?php if ($first_part=="product_payout.php") {echo "actives"; } else  {echo "noactive";}?>">
                                            <a href="product_payout.php" class="nav-link menu-link">
                                                <span data-key="t-contracting-payout">Product Payout</span>
                                            </a>
                                        </li>
                                    <?php 
                                        } 
                                    ?>
                                    <?php 
                                        if($userType == "3"){ 
                                    ?>
                                        <li class="nav-item  <?php if ($first_part=="contracting_payout.php") {echo "actives"; } else  {echo "noactive";}?>">
                                            <a href="contracting_payout.php" class="nav-link menu-link">
                                                <span data-key="t-contracting-payout">C.A. Contracting Payout</span>
                                            </a>
                                        </li>
                                    <?php 
                                        } 
                                        if($userType == "3" || $userType == "16"){ 
                                    ?>    
                                    <li class="nav-item  <?php if ($first_part=="recruitment_payout.php") {echo "actives"; } else  {echo "noactive";}?>">
                                        <a href="recruitment_payout.php" class="nav-link menu-link">
                                            <span data-key="t-recruitment-payout">T.A. Recruitment Payout</span>
                                        </a>
                                    </li>
                                    <?php } 
                                        if($userType == "26"){ 
                                    ?>
                                    <li class="nav-item  <?php if ($first_part=="bm_recruitment_payout_slab.php") {echo "actives"; } else  {echo "noactive";}?>">
                                        <a href="bm_recruitment_payout_slab.php" class="nav-link menu-link">
                                            <span data-key="t-recruitment-payout">BM Payout</span>
                                        </a>
                                    </li>
                                    <?php 
                                        }else if($userType == "24"){
                                    ?>  
                                    <li class="nav-item  <?php if ($first_part=="bcm_recruitement_payout_slab.php") {echo "actives"; } else  {echo "noactive";}?>">
                                        <a href="bcm_recruitement_payout_slab.php" class="nav-link menu-link">
                                            <span data-key="t-recruitment-payout">BCM Payout</span>
                                        </a>
                                    </li>
                                    <?php 
                                        }else if($userType == "25"){
                                    ?>  
                                    <li class="nav-item  <?php if ($first_part=="bdm_recruitement_payout_slab.php") {echo "actives"; } else  {echo "noactive";}?>">
                                        <a href="bdm_recruitment_payout_slab.php" class="nav-link menu-link">
                                            <span data-key="t-recruitment-payout">BDM Payout</span>
                                        </a>
                                    </li>
                                    <?php 
                                        }
                                    ?> 
                                </ul>
                            </div>
                        </li>
                    <?php } ?>

                  

                    <?php             
                        if($userType == "3"){ 
                    ?>
                        <li class="nav-item <?php if ($first_part=="order_history.php") {echo "actives"; } else  {echo "noactive";}?>">
                            <a class="nav-link menu-link" href="order_history.php" role="button" aria-expanded="false" aria-controls="sidebarDashboards">
                                <i class="ri-contacts-line"></i> <span data-key="t-order-history">Travel History</span>
                            </a>
                        </li>
                        <!-- <li class="nav-item <?php if ($first_part=="markup.php") {echo "actives"; } else  {echo "noactive";}?>">
                            <a class="nav-link menu-link" href="markup.php" role="button" aria-expanded="false" aria-controls="sidebarDashboards">
                                <i class="ri-contacts-line"></i> <span data-key="t-order-history">Markup</span>
                            </a>
                        </li> -->
                        <li class="nav-item <?php if ($first_part=="terms-condition-consultant.php") {echo "actives"; } else  {echo "noactive";}?>">
                            <a class="nav-link menu-link" href="terms-condition-consultant.php" role="button" aria-expanded="false" aria-controls="sidebarDashboards">
                                <i class="ri-contacts-line"></i> <span data-key="t-order-history">Terms Condition</span>
                            </a>
                        </li>
                    <?php             
                        }
                    ?>

                    <?php             
                        if($userType == "18"){ 
                    ?>
                        <li class="nav-item <?php if ($first_part=="view_business_consultant.php") {echo "actives"; } else  {echo "noactive";}?>">
                            <a class="nav-link menu-link" href="view_business_consultant.php" role="button" aria-expanded="false" aria-controls="sidebarDashboards">
                                <i class="ri-contacts-line"></i> <span data-key="t-order-history">Business Consultant</span>
                            </a>
                        </li>
                        <li class="nav-item <?php if ($first_part=="view_corporate_agency.php") {echo "actives"; } else  {echo "noactive";}?>">
                            <a class="nav-link menu-link" href="view_corporate_agency.php" role="button" aria-expanded="false" aria-controls="sidebarDashboards">
                                <i class="ri-contacts-line"></i> <span data-key="t-order-history">Corporate Agency</span>
                            </a>
                        </li>
                        <li class="nav-item <?php if ($first_part=="view_travel_agent.php") {echo "actives"; } else  {echo "noactive";}?>">
                            <a class="nav-link menu-link" href="view_travel_agent.php" role="button" aria-expanded="false" aria-controls="sidebarDashboards">
                                <i class="ri-contacts-line"></i> <span data-key="t-order-history">Travel Consultant</span>
                            </a>
                        </li>
                        <li class="nav-item <?php if ($first_part=="view_customer.php") {echo "actives"; } else  {echo "noactive";}?>">
                            <a class="nav-link menu-link" href="view_customer.php" role="button" aria-expanded="false" aria-controls="sidebarDashboards">
                                <i class="ri-contacts-line"></i> <span data-key="t-order-history">Customer</span>
                            </a>
                        </li>
                        <li class="nav-item">  
                            <a class="nav-link menu-link" href="#sidebarMultilevel" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarMultilevel">
                                <i class="mdi mdi-share-variant-outline"></i> <span data-key="t-multi-level">Payouts</span>
                            </a>
                            <div class="collapse menu-dropdown" id="sidebarMultilevel">
                                <ul class="nav nav-sm flex-column">
                                    <li class="nav-item  <?php if ($first_part=="cbd_payout.php") {echo "actives"; } else  {echo "noactive";}?>">
                                        <a href="cbd_payout.php" class="nav-link menu-link">
                                            <span data-key="t-contracting-payout">CBD Payout</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <!-- <li class="nav-item <?php if ($first_part=="view_cbd.php") {echo "actives"; } else  {echo "noactive";}?>">
                            <a class="nav-link menu-link" href="view_cbd.php" role="button" aria-expanded="false" aria-controls="sidebarDashboards">
                                <i class="ri-contacts-line"></i> <span data-key="t-order-history">Channel Business Director</span>
                            </a>
                        </li> -->
                        
                    <?php             
                        }
                    ?>
                    <?php             
                        if($userType == "19"){ 
                    ?>
                        <li class="nav-item <?php if ($first_part=="view_business_operation_executive.php") {echo "actives"; } else  {echo "noactive";}?>">
                            <a class="nav-link menu-link" href="view_business_operation_executive.php" role="button" aria-expanded="false" aria-controls="sidebarDashboards">
                                <i class="ri-contacts-line"></i> <span data-key="t-order-history">Business Operative Executive</span>
                            </a>
                        </li>
                        <li class="nav-item <?php if ($first_part=="view_training_manager.php") {echo "actives"; } else  {echo "noactive";}?>">
                            <a class="nav-link menu-link" href="view_training_manager.php" role="button" aria-expanded="false" aria-controls="sidebarDashboards">
                                <i class="ri-contacts-line"></i> <span data-key="t-order-history">Training Manager</span>
                            </a>
                        </li>
                        <li class="nav-item <?php if ($first_part=="view_sales_manager_executive.php") {echo "actives"; } else  {echo "noactive";}?>">
                            <a class="nav-link menu-link" href="view_sales_manager_executive.php" role="button" aria-expanded="false" aria-controls="sidebarDashboards">
                                <i class="ri-contacts-line"></i> <span data-key="t-order-history">Sales Manager / Executive</span>
                            </a>
                        </li>
                        <!-- <li class="nav-item <?php if ($first_part=="view_cbd.php") {echo "actives"; } else  {echo "noactive";}?>">
                            <a class="nav-link menu-link" href="view_cbd.php" role="button" aria-expanded="false" aria-controls="sidebarDashboards">
                                <i class="ri-contacts-line"></i> <span data-key="t-order-history">Channel Business Director</span>
                            </a>
                        </li> -->
                        
                    <?php             
                        }
                    ?>

                    <?php             
                        if($userType == "24"){ 
                    ?>
                        <li class="nav-item <?php if ($first_part=="view_business_development_manager.php") {echo "actives"; } else  {echo "noactive";}?>">
                            <a class="nav-link menu-link" href="view_business_development_manager.php" role="button" aria-expanded="false" aria-controls="sidebarDashboards">
                                <i class="ri-contacts-line"></i> <span data-key="t-order-history">Business Development Manager</span>
                            </a>
                        </li>
                        <li class="nav-item <?php if ($first_part=="view_business_mentor.php") {echo "actives"; } else  {echo "noactive";}?>">
                            <a class="nav-link menu-link" href="view_business_mentor.php" role="button" aria-expanded="false" aria-controls="sidebarDashboards">
                                <i class="ri-contacts-line"></i> <span data-key="t-order-history">Business Mentor</span>
                            </a>
                        </li>
                        <li class="nav-item <?php if ($first_part=="view_corporate_agency.php") {echo "actives"; } else  {echo "noactive";}?>">
                            <a class="nav-link menu-link" href="view_corporate_agency.php" role="button" aria-expanded="false" aria-controls="sidebarDashboards">
                                <i class="ri-contacts-line"></i> <span data-key="t-order-history">Techno Enterprise</span>
                            </a>
                        </li>
                        <li class="nav-item <?php if ($first_part=="view_travel_agent.php") {echo "actives"; } else  {echo "noactive";}?>">
                            <a class="nav-link menu-link" href="view_travel_agent.php" role="button" aria-expanded="false" aria-controls="sidebarDashboards">
                                <i class="ri-contacts-line"></i> <span data-key="t-order-history">Travel Consultant</span>
                            </a>
                        </li>
                        <li class="nav-item <?php if ($first_part=="view_customer.php") {echo "actives"; } else  {echo "noactive";}?>">
                            <a class="nav-link menu-link" href="view_customer.php" role="button" aria-expanded="false" aria-controls="sidebarDashboards">
                                <i class="ri-contacts-line"></i> <span data-key="t-order-history">Customer</span>
                            </a>
                        </li>
                    <?php             
                        }
                    ?>

                    <?php             
                        if($userType == "25"){ 
                    ?>
                        <!-- <li class="nav-item <?php if ($first_part=="view_business_development_manager.php") {echo "actives"; } else  {echo "noactive";}?>">
                            <a class="nav-link menu-link" href="view_business_development_manager.php" role="button" aria-expanded="false" aria-controls="sidebarDashboards">
                                <i class="ri-contacts-line"></i> <span data-key="t-order-history">Business Development Manager</span>
                            </a>
                        </li> -->
                        <li class="nav-item <?php if ($first_part=="view_business_mentor.php") {echo "actives"; } else  {echo "noactive";}?>">
                            <a class="nav-link menu-link" href="view_business_mentor.php" role="button" aria-expanded="false" aria-controls="sidebarDashboards">
                                <i class="ri-contacts-line"></i> <span data-key="t-order-history">Business Mentor</span>
                            </a>
                        </li>
                        <li class="nav-item <?php if ($first_part=="view_corporate_agency.php") {echo "actives"; } else  {echo "noactive";}?>">
                            <a class="nav-link menu-link" href="view_corporate_agency.php" role="button" aria-expanded="false" aria-controls="sidebarDashboards">
                                <i class="ri-contacts-line"></i> <span data-key="t-order-history">Techno Enterprise</span>
                            </a>
                        </li>
                        <li class="nav-item <?php if ($first_part=="view_travel_agent.php") {echo "actives"; } else  {echo "noactive";}?>">
                            <a class="nav-link menu-link" href="view_travel_agent.php" role="button" aria-expanded="false" aria-controls="sidebarDashboards">
                                <i class="ri-contacts-line"></i> <span data-key="t-order-history">Travel Consultant</span>
                            </a>
                        </li>
                        <li class="nav-item <?php if ($first_part=="view_customer.php") {echo "actives"; } else  {echo "noactive";}?>">
                            <a class="nav-link menu-link" href="view_customer.php" role="button" aria-expanded="false" aria-controls="sidebarDashboards">
                                <i class="ri-contacts-line"></i> <span data-key="t-order-history">Customer</span>
                            </a>
                        </li>
                    <?php             
                        }
                    ?>

                    <?php             
                        if($userType == "26"){ 
                    ?>
                        <!-- <li class="nav-item <?php if ($first_part=="view_business_development_manager.php") {echo "actives"; } else  {echo "noactive";}?>">
                            <a class="nav-link menu-link" href="view_business_development_manager.php" role="button" aria-expanded="false" aria-controls="sidebarDashboards">
                                <i class="ri-contacts-line"></i> <span data-key="t-order-history">Business Development Manager</span>
                            </a>
                        </li> -->
                        <!-- <li class="nav-item <?php if ($first_part=="view_business_mentor.php") {echo "actives"; } else  {echo "noactive";}?>">
                            <a class="nav-link menu-link" href="view_business_mentor.php" role="button" aria-expanded="false" aria-controls="sidebarDashboards">
                                <i class="ri-contacts-line"></i> <span data-key="t-order-history">Business Mentor</span>
                            </a>
                        </li> -->
                        <li class="nav-item <?php if ($first_part=="view_corporate_agency.php") {echo "actives"; } else  {echo "noactive";}?>">
                            <a class="nav-link menu-link" href="view_corporate_agency.php" role="button" aria-expanded="false" aria-controls="sidebarDashboards">
                                <i class="ri-contacts-line"></i> <span data-key="t-order-history">Techno Enterprise</span>
                            </a>
                        </li>
                        <li class="nav-item <?php if ($first_part=="view_travel_agent.php") {echo "actives"; } else  {echo "noactive";}?>">
                            <a class="nav-link menu-link" href="view_travel_agent.php" role="button" aria-expanded="false" aria-controls="sidebarDashboards">
                                <i class="ri-contacts-line"></i> <span data-key="t-order-history">Travel Consultant</span>
                            </a>
                        </li>
                        <li class="nav-item <?php if ($first_part=="view_customer.php") {echo "actives"; } else  {echo "noactive";}?>">
                            <a class="nav-link menu-link" href="view_customer.php" role="button" aria-expanded="false" aria-controls="sidebarDashboards">
                                <i class="ri-contacts-line"></i> <span data-key="t-order-history">Customer</span>
                            </a>
                        </li>
                    <?php             
                        }
                    ?>
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
                    <li class="nav-item <?php if ($first_part=="order_history.php") {echo "actives"; } else  {echo "noactive";}?>">
                        <a class="nav-link menu-link" href="order_history.php" role="button" aria-expanded="false" aria-controls="sidebarDashboards">
                            <i class="ri-contacts-line"></i> <span data-key="t-customer">Travel History</span>
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
    <div class="vertical-overlay"></div>