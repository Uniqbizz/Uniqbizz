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
                    <li class="nav-item <?php if ($first_part=="index.php") {echo "actives"; } else  {echo "noactive";}?>">
                        <a class="nav-link menu-link" href="index.php" role="button" aria-expanded="false" aria-controls="sidebarDashboards">
                            <i class="ri-layout-masonry-line"></i> <span data-key="t-dashboards">Dashboards</span>
                        </a>
                    </li>
                    <li class="nav-item <?php if ($first_part=="../../index.php") {echo "actives"; } else  {echo "noactive";}?>">
                        <a class="nav-link menu-link" href="../../index.php" role="button" aria-expanded="false" aria-controls="sidebarDashboards">
                            <i class="ri-layout-masonry-line"></i> <span data-key="t-home">Home Page</span>
                        </a>
                    </li>
                    <?php 
                        if($userType == "3"){ ?>
                            
                            <li class="nav-item <?php if ($first_part=="../views/view_corporate_agency.php") {echo "actives"; } else  {echo "noactive";}?>">
                                <a class="nav-link menu-link" href="../views/view_corporate_agency.php" role="button" aria-expanded="false" aria-controls="sidebarDashboards">
                                    <i class="ri-contacts-line"></i> <span data-key="t-corporate-agency">Corporate Agency</span>
                                </a>
                            </li>
                            <li class="nav-item <?php if ($first_part=="../views/view_travel_agent.php") {echo "actives"; } else  {echo "noactive";}?>">
                                <a class="nav-link menu-link" href="../views/view_travel_agent.php" role="button" aria-expanded="false" aria-controls="sidebarDashboards">
                                    <i class="ri-contacts-line"></i> <span data-key="t-travel-agent">Travel Consultant</span>
                                </a>
                            </li>
                            <li class="nav-item <?php if ($first_part=="../views/view_customer.php") {echo "actives"; } else  {echo "noactive";}?>">
                                <a class="nav-link menu-link" href="../views/view_customer.php" role="button" aria-expanded="false" aria-controls="sidebarDashboards">
                                    <i class="ri-contacts-line"></i> <span data-key="t-customer">Customer</span>
                                </a>
                            </li>
                    <?php
                        }else if($userType == "16" || $userType == "29" || $userType == "32"){
                    ?>
                        
                        </li>
                        <li class="nav-item <?php if ($first_part=="../views/view_travel_agent.php") {echo "actives"; } else  {echo "noactive";}?>">
                            <a class="nav-link menu-link" href="../views/view_travel_agent.php" role="button" aria-expanded="false" aria-controls="sidebarDashboards">
                                <i class="ri-contacts-line"></i> <span data-key="t-travel-agent">Travel Consultant</span>
                            </a>
                        </li>
                        <li class="nav-item <?php if ($first_part=="../views/view_customer.php") {echo "actives"; } else  {echo "noactive";}?>">
                            <a class="nav-link menu-link" href="../views/view_customer.php" role="button" aria-expanded="false" aria-controls="sidebarDashboards">
                                <i class="ri-contacts-line"></i> <span data-key="t-customer">Customer</span>
                            </a>
                        </li>
                        
                    <?php  
                        }else if($userType == "11" || $userType == "33"){
                    ?>
                        
                        <!-- <li class="nav-item <?php if ($first_part=="../views/markup.php") {echo "actives"; } else  {echo "noactive";}?>">
                            <a class="nav-link menu-link" href="../views/markup.php" role="button" aria-expanded="false" aria-controls="sidebarDashboards">
                                <i class="ri-contacts-line"></i> <span data-key="t-markup">Markup</span>
                            </a>
                        </li> -->
                        <li class="nav-item <?php if ($first_part=="../views/view_customer.php") {echo "actives"; } else  {echo "noactive";}?>">
                            <a class="nav-link menu-link" href="../views/view_customer.php" role="button" aria-expanded="false" aria-controls="sidebarDashboards">
                                <i class="ri-contacts-line"></i> <span data-key="t-customer">Customer</span>
                            </a>
                        </li>
                    <?php  
                        }else if($userType == "10"){
                    ?>
                        <li class="nav-item <?php if ($first_part=="../views/view_customer.php") {echo "actives"; } else  {echo "noactive";}?>">
                            <a class="nav-link menu-link" href="../views/view_customer.php" role="button" aria-expanded="false" aria-controls="sidebarDashboards">
                                <i class="ri-contacts-line"></i> <span data-key="t-customer">Customer</span>
                            </a>
                        </li>
                    <?php } ?>   

                    <?php  
                         if($userType != "18" && $userType != "19" && $userType !="24" && $userType !="25" && $userType!='31' && $userType!='33'){
                    ?>
                        <li class="nav-item">  <!--payout -->
                            <a class="nav-link menu-link" href="#sidebarMultilevel" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarMultilevel">
                                <i class="mdi mdi-share-variant-outline"></i> <span data-key="t-multi-level">Payouts</span>
                            </a>
                            <div class="collapse menu-dropdown" id="sidebarMultilevel">
                                <ul class="nav nav-sm flex-column">
                                    <?php 
                                        if($userType == "26" || $userType == "16" || $userType == "11" || $userType == "10" || $userType == "28" || $userType == "29" || $userType =="30" || $userType =="31" || $userType =="32"){ 
                                    ?>
                                        <li class="nav-item  <?php if ($first_part=="../views/product_payout.php") {echo "actives"; } else  {echo "noactive";}?>">
                                            <a href="../views/product_payout.php" class="nav-link menu-link">
                                                <span data-key="t-contracting-payout">Product Payout</span>
                                            </a>
                                        </li>
                                    <?php
                                        }
                                        if($userType == "26" || $userType == "16" || $userType == "11" || $userType == "28" || $userType == "29" || $userType =="30" || $userType =="32"){ 
                                    ?>
                                        <li class="nav-item  <?php if ($first_part=="../views/customer_recruitment_payout.php") {echo "actives"; } else  {echo "noactive";}?>">
                                            <a href="../views/customer_recruitment_payout.php" class="nav-link menu-link">
                                                <!-- <span data-key="t-contracting-payout">CU Membership Payout</span> -->
                                                <span data-key="t-contracting-payout">Holiday Account Payout</span>
                                            </a>
                                        </li>
                                    <?php 
                                        } 
                                        if ($userType =='10') {
                                    ?>
                                        <li class="nav-item  <?php if ($first_part=="../views/customer_referance_payout.php") {echo "actives"; } else  {echo "noactive";}?>">
                                            <a href="../views/customer_referance_payout.php" class="nav-link menu-link">
                                                <span data-key="t-contracting-payout">CU Reference Payout</span>
                                            </a>
                                        </li>
                                    <?php
                                        }if ($userType == "28" || $userType =="30"){
                                    ?>
                                        <li class="nav-item  <?php if ($first_part=="../views/sub_franchisee_payout.php") {echo "actives"; } else  {echo "noactive";}?>">
                                            <a href="../views/sub_franchisee_payout.php" class="nav-link menu-link">
                                                <span data-key="t-contracting-payout">Franchisee Contracting Payout</span>
                                            </a>
                                        </li>
                                    <?php
                                        }
                                        if($userType == "3"){ 
                                    ?>
                                        <li class="nav-item  <?php if ($first_part=="../views/contracting_payout.php") {echo "actives"; } else  {echo "noactive";}?>">
                                            <a href="../views/contracting_payout.php" class="nav-link menu-link">
                                                <span data-key="t-contracting-payout">C.A. Contracting Payout</span>
                                            </a>
                                        </li>
                                    <?php 
                                        } 
                                        if($userType == "3" || $userType == "16" || $userType == "28" || $userType =="29" || $userType == "26" || $userType == "30" || $userType == "25" || $userType == "31"){ 
                                    ?>    
                                    <li class="nav-item  <?php if ($first_part=="../views/recruitment_payout.php") {echo "actives"; } else  {echo "noactive";}?>">
                                        <a href="../views/recruitment_payout.php" class="nav-link menu-link">
                                            <span data-key="t-recruitment-payout">TC Recruitment Payout</span>
                                        </a>
                                    </li>
                                    <?php } 
                                        if($userType == "26"){ 
                                    ?>
                                    <li class="nav-item  <?php if ($first_part=="../views/bm_recruitment_payout_slab.php") {echo "actives"; } else  {echo "noactive";}?>">
                                        <a href="../views/bm_recruitment_payout_slab.php" class="nav-link menu-link">
                                            <span data-key="t-recruitment-payout">BM Payout</span>
                                        </a>
                                    </li>
                                    <?php 
                                        }else if($userType == "24"){
                                    ?>  
                                    <li class="nav-item  <?php if ($first_part=="../views/bcm_recruitement_payout_slab.php") {echo "actives"; } else  {echo "noactive";}?>">
                                        <a href="../views/bcm_recruitement_payout_slab.php" class="nav-link menu-link">
                                            <span data-key="t-recruitment-payout">BCM Payout</span>
                                        </a>
                                    </li>
                                    <?php 
                                        }else if($userType == "25"){
                                    ?>  
                                    <li class="nav-item  <?php if ($first_part=="../views/bdm_recruitement_payout_slab.php") {echo "actives"; } else  {echo "noactive";}?>">
                                        <a href="../views/bdm_recruitment_payout_slab.php" class="nav-link menu-link">
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
                        <li class="nav-item <?php if ($first_part=="../views/order_history.php") {echo "actives"; } else  {echo "noactive";}?>">
                            <a class="nav-link menu-link" href="../views/order_history.php" role="button" aria-expanded="false" aria-controls="sidebarDashboards">
                                <i class="ri-contacts-line"></i> <span data-key="t-order-history">Tour History</span>
                            </a>
                        </li>
                        <li class="nav-item <?php if ($first_part=="../views/terms-condition-consultant.php") {echo "actives"; } else  {echo "noactive";}?>">
                            <a class="nav-link menu-link" href="../views/terms-condition-consultant.php" role="button" aria-expanded="false" aria-controls="sidebarDashboards">
                                <i class="ri-contacts-line"></i> <span data-key="t-order-history">Terms Condition</span>
                            </a>
                        </li>
                    <?php             
                        }
                    ?>

                    <?php             
                        if($userType == "18"){ 
                    ?>
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
                        
                    <?php             
                        }
                    ?>

                    <?php             
                        if($userType == "24"){ 
                    ?>
                        <li class="nav-item <?php if ($first_part=="../views/view_business_development_manager.php") {echo "actives"; } else  {echo "noactive";}?>">
                            <a class="nav-link menu-link" href="../views/view_business_development_manager.php" role="button" aria-expanded="false" aria-controls="sidebarDashboards">
                                <i class="ri-contacts-line"></i> <span data-key="t-order-history">Business Development Manager</span>
                            </a>
                        </li>
                        <li class="nav-item <?php if ($first_part=="../views/view_business_mentor.php") {echo "actives"; } else  {echo "noactive";}?>">
                            <a class="nav-link menu-link" href="../views/view_business_mentor.php" role="button" aria-expanded="false" aria-controls="sidebarDashboards">
                                <i class="ri-contacts-line"></i> <span data-key="t-order-history">BM/MF/SF</span>
                            </a>
                        </li>
                        <li class="nav-item <?php if ($first_part=="../views/view_corporate_agency.php") {echo "actives"; } else  {echo "noactive";}?>">
                            <a class="nav-link menu-link" href="../views/view_corporate_agency.php" role="button" aria-expanded="false" aria-controls="sidebarDashboards">
                                <i class="ri-contacts-line"></i> <span data-key="t-order-history">TE/F</span>
                            </a>
                        </li>
                        <li class="nav-item <?php if ($first_part=="../views/view_travel_agent.php") {echo "actives"; } else  {echo "noactive";}?>">
                            <a class="nav-link menu-link" href="../views/view_travel_agent.php" role="button" aria-expanded="false" aria-controls="sidebarDashboards">
                                <i class="ri-contacts-line"></i> <span data-key="t-order-history">Travel Consultant</span>
                            </a>
                        </li>
                        <li class="nav-item <?php if ($first_part=="../views/view_customer.php") {echo "actives"; } else  {echo "noactive";}?>">
                            <a class="nav-link menu-link" href="../views/view_customer.php" role="button" aria-expanded="false" aria-controls="sidebarDashboards">
                                <i class="ri-contacts-line"></i> <span data-key="t-order-history">Customer</span>
                            </a>
                        </li>
                    <?php             
                        }
                    ?>

                    <?php             
                        if($userType == "25"){ 
                    ?>
                        <li class="nav-item <?php if ($first_part=="../views/view_business_mentor.php") {echo "actives"; } else  {echo "noactive";}?>">
                            <a class="nav-link menu-link" href="../views/view_business_mentor.php" role="button" aria-expanded="false" aria-controls="sidebarDashboards">
                                <i class="ri-contacts-line"></i> <span data-key="t-order-history">BM/SF/MF</span>
                            </a>
                        </li>
                        <li class="nav-item <?php if ($first_part=="../views/view_corporate_agency.php") {echo "actives"; } else  {echo "noactive";}?>">
                            <a class="nav-link menu-link" href="../views/view_corporate_agency.php" role="button" aria-expanded="false" aria-controls="sidebarDashboards">
                                <i class="ri-contacts-line"></i> <span data-key="t-order-history">TE/F</span>
                            </a>
                        </li>
                        <li class="nav-item <?php if ($first_part=="../views/view_travel_agent.php") {echo "actives"; } else  {echo "noactive";}?>">
                            <a class="nav-link menu-link" href="../views/view_travel_agent.php" role="button" aria-expanded="false" aria-controls="sidebarDashboards">
                                <i class="ri-contacts-line"></i> <span data-key="t-order-history">Travel Consultant</span>
                            </a>
                        </li>
                        <li class="nav-item <?php if ($first_part=="../views/view_customer.php") {echo "actives"; } else  {echo "noactive";}?>">
                            <a class="nav-link menu-link" href="../views/view_customer.php" role="button" aria-expanded="false" aria-controls="sidebarDashboards">
                                <i class="ri-contacts-line"></i> <span data-key="t-order-history">Customer</span>
                            </a>
                        </li>
                    <?php             
                        }
                    ?>
                    <?php             
                        if($userType == "31"){ 
                    ?>
                        <li class="nav-item <?php if ($first_part=="../views/view_business_mentor.php") {echo "actives"; } else  {echo "noactive";}?>">
                            <a class="nav-link menu-link" href="../views/view_business_mentor.php" role="button" aria-expanded="false" aria-controls="sidebarDashboards">
                                <i class="ri-contacts-line"></i> <span data-key="t-order-history">SF/MF</span>
                            </a>
                        </li>
                        <li class="nav-item <?php if ($first_part=="../views/view_corporate_agency.php") {echo "actives"; } else  {echo "noactive";}?>">
                            <a class="nav-link menu-link" href="../views/view_corporate_agency.php" role="button" aria-expanded="false" aria-controls="sidebarDashboards">
                                <i class="ri-contacts-line"></i> <span data-key="t-order-history">Franchisee</span>
                            </a>
                        </li>
                        <li class="nav-item <?php if ($first_part=="../views/view_travel_agent.php") {echo "actives"; } else  {echo "noactive";}?>">
                            <a class="nav-link menu-link" href="../views/view_travel_agent.php" role="button" aria-expanded="false" aria-controls="sidebarDashboards">
                                <i class="ri-contacts-line"></i> <span data-key="t-order-history">Travel Consultant</span>
                            </a>
                        </li>
                        <li class="nav-item <?php if ($first_part=="../views/view_customer.php") {echo "actives"; } else  {echo "noactive";}?>">
                            <a class="nav-link menu-link" href="../views/view_customer.php" role="button" aria-expanded="false" aria-controls="sidebarDashboards">
                                <i class="ri-contacts-line"></i> <span data-key="t-order-history">Customer</span>
                            </a>
                        </li>
                    <?php             
                        }
                    ?>

                    <?php             
                        if($userType == "26" || $userType == "28" || $userType =="30"){ 
                            
                    ?>
                        <li class="nav-item <?php if ($first_part=="../views/view_corporate_agency.php") {echo "actives"; } else  {echo "noactive";}?>">
                            <a class="nav-link menu-link" href="../views/view_corporate_agency.php" role="button" aria-expanded="false" aria-controls="sidebarDashboards">
                                <i class="ri-contacts-line"></i> <span data-key="t-order-history"><?=($userType == "28"|| $userType =="30")? 'Franchisee':'Techno Enterprise'?></span>
                            </a>
                        </li>
                        <li class="nav-item <?php if ($first_part=="../views/view_travel_agent.php") {echo "actives"; } else  {echo "noactive";}?>">
                            <a class="nav-link menu-link" href="../views/view_travel_agent.php" role="button" aria-expanded="false" aria-controls="sidebarDashboards">
                                <i class="ri-contacts-line"></i> <span data-key="t-order-history">Travel Consultant</span>
                            </a>
                        </li>
                        <li class="nav-item <?php if ($first_part=="../views/view_customer.php") {echo "actives"; } else  {echo "noactive";}?>">
                            <a class="nav-link menu-link" href="../views/view_customer.php" role="button" aria-expanded="false" aria-controls="sidebarDashboards">
                                <i class="ri-contacts-line"></i> <span data-key="t-order-history">Customer</span>
                            </a>
                        </li>
                    <?php             
                        }
                    ?>
                    <li class="nav-item <?php if ($first_part=="../views/order_history.php") {echo "actives"; } else  {echo "noactive";}?>">
                        <a class="nav-link menu-link" href="../views/order_history.php" role="button" aria-expanded="false" aria-controls="sidebarDashboards">
                            <i class="ri-contacts-line"></i> <span data-key="t-customer">Tour History</span>
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