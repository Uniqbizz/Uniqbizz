<style>
    .vertical-menu{
        background-color: #f8f8fb !important;
    }
</style>

<!-- ========== Left Sidebar Start ========== -->
<div class="vertical-menu">

    <div data-simplebar class="h-100">

        <!--- Sidemenu -->
        <div id="sidebar-menu" class="card mt-4 ms-2 rounded-4 pb-5">
            <!-- Left Menu Start -->

            <ul class="metismenu list-unstyled" id="side-menu">
                <li class="menu-title" key="t-menu">Menu</li>

                <li>
                    <a href="../../views/home/index.php" class="waves-effect">
                        <i class="bx bx-home-circle"></i>
                        <span key="t-dashboards">Dashboards</span>
                    </a>
                </li>
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="bx bxs-user-detail"></i>
                        <span key="t-multi-level">Employee</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="true">
                        <li><a href="../../views/employee/employee.php" key="t-level-1-1"><i class="bx bxs-user-detail"></i>All Employee</a></li>
                        <li><a href="../../views/departments/departments.php" key="t-level-1-1"><i class="bx bxs-user-detail"></i>Dept / Desig</a></li>
                    </ul>
                </li>
                <li>
                    <a href="../../views/business_mentor/businessMentor.php" class=" waves-effect">
                        <i class="bx bxs-user-detail"></i>
                        <span key="t-contacts">BM / MF / SF</span>
                    </a>
                </li>
                <li>
                    <a href="../../views/corporate_agency/view_corporate_agency.php" class=" waves-effect">
                        <i class="bx bxs-user-detail"></i>
                        <span key="t-contacts">TE / F / IN</span>
                    </a>
                </li>
                <li>
                    <a href="../../views/ca_travel_agency/view_ca_travelAgency.php" class=" waves-effect">
                        <i class="bx bxs-user-detail"></i>
                        <span key="t-contacts">Travel Consultant</span>
                    </a>
                </li>
                <li>
                    <a href="../../views/ca_customer/view_customers.php" class=" waves-effect">
                        <i class="bx bxs-user-detail"></i>
                        <span key="t-contacts">Customers</span>
                    </a>
                </li>
                <li>
                    <a href="../../views/channels/all_channels.php" class=" waves-effect">
                        <i class="bx bxs-user-detail"></i>
                        <span key="t-contacts">Channels</span>
                    </a>
                </li>
                <li>
                    <a href="../../views/user_details/all_users.php" class=" waves-effect">
                        <i class="bx bxs-user-detail"></i>
                        <span key="t-contacts">Login Details</span>
                    </a>
                </li>
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="bx bxs-collection"></i>
                        <span key="t-multi-level">Payout</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="true">
                        <li><a href="../../views/slab_payout/slabPayout.php" key="t-level-1-1"><i class="bx bxs-detail"></i>Employee Payout</a></li>
                        <li><a href="../../views/payout/sub_franchisee_payout.php" key="t-level-1-1"><i class="bx bxs-detail"></i>Franchisee Contracting Payout</a></li>
                        <li><a href="../../views/payout/contracting_payout.php" key="t-level-1-1"><i class="bx bxs-detail"></i>TE Contracting Payout</a></li>
                        <li><a href="../../views/payout/recruitment_payout.php" key="t-level-1-1"><i class="bx bxs-detail"></i>TC Recruitment Payout</a></li>
                        <!-- CU Membership Payout Renamed to holiday account payout -->
                        <li><a href="../../views/payout/customer_membership_payout.php" key="t-level-1-1"><i class="bx bxs-detail"></i>Holiday Account Payout</a></li>
                        <li><a href="../../views/payout/customer_referance_payout.php" key="t-level-1-1"><i class="bx bxs-detail"></i>CU Reference Payout</a></li>
                        <li><a href="../../views/payout/product_payout.php" key="t-level-1-1"><i class="bx bxs-detail"></i>Product Payout</a></li>
                    </ul>
                </li>
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="bx bxs-user-detail"></i>
                        <span key="t-multi-level">Packages</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="true">
                        <li><a href="../../views/packages/all_packages.php" class=" waves-effect"><i class="bx bxs-user-detail"></i><span key="t-contacts">Packages</span></a></li>
                        <li><a href="../../views/orders/order_history.php" class=" waves-effect"><i class="bx bxs-user-detail"></i><span key="t-contacts">Order History</span></a></li>
                        <li><a href="../../views/package_markup/markup.php" class=" waves-effect"><i class="bx bxs-user-detail"></i><span key="t-contacts">Package Markup</span></a></li>
                        <li><a href="../../views/amenities/manage_amenities.php" class=" waves-effect"><i class="bx bxs-user-detail"></i><span key="t-contacts">Amenities</span></a></li>
                        <li><a href="../../views/category/manage_categories.php" class=" waves-effect"><i class="bx bxs-user-detail"></i><span key="t-contacts">Category</span></a></li>
                        <li><a href="../../views/quotation/quotations.php" class=" waves-effect"><i class="bx bxs-user-detail"></i><span key="t-contacts">Quotations</span></a></li>
                        <!-- topup wallent for TA by sv on 28-01-2025-->
                        <li><a class="waves-effect" href="../../views/ta-top-up/ta_top_up.php"><i class="bx bx-wallet font-size-16 align-middle me-1"></i> <span key="ta-topup-wallet">TA Top-up Wallet</span></a></li>
                        
                    </ul>
                </li>
                <li>
                    <!-- <button class="text-center ms-3 mt-3"> -->
                        <a href="../../logout.php" class="dropdown-item btn rounded-pill text-white text-center mt-3 ms-3 w-50 waves-effect" style="background-color: #556ee6">
                            <i class="bx bx-power-off" style="margin-left: -14px !important;"></i>
                            <span class="t-logout">Logout</span>
                        </a>
                    <!-- </button> -->
                </li>
        </div>
        <!-- Sidebar -->
    </div>
</div>
<!-- Left Sidebar End -->

<!-- vertical-overlay -->
<div class="vertical-overlay"></div>