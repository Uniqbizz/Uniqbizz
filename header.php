<header>
    <div class="header-area">
        <div class="main-header">
            <!-- Header Top -->
            <div class="header-top">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="top-menu-wrapper d-flex align-items-center justify-content-between">
                                <!-- Top Left Side -->
                                <div class="top-header-left d-flex align-items-center">
                                    <!-- Logo-->
                                    <div class="logo">
                                        <a href="index.php"><img src="assets/images/bizz_logo.png" height="55px" width="80px" ></a>
                                    </div>
                                </div>
                                <!--Top Right Side -->
                                <div class="top-header-right">
                                    <!-- contact us -->
                                    <div class="contact-section">
                                        <div class="circle-primary-sm">
                                            <i class="ri-mail-line"></i>
                                        </div>
                                        <div class="info">
                                            <p class="pera">Email Anytime</p>
                                            <h4 class="title">
                                                <a href="javascript:void(0)">support@bizzmirth.com</a>
                                            </h4>
                                        </div>
                                    </div>
                                    <div class="contact-section">
                                        <div class="circle-primary-sm">
                                            <i class="ri-phone-line"></i>
                                        </div>
                                        <div class="info">
                                            <p class="pera">Call Anytime</p>
                                            <h4 class="title">
                                                <a href="javascript:void(0)">+91 8010892265</a>
                                            </h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Header Bottom -->
            <div class="header-bottom header-sticky">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="menu-wrapper">
                                <!-- Main-menu for desktop -->
                                <div class="main-menu d-none d-lg-block">
                                    <nav>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <ul class="listing" id="navigation">
                                                <li class="single-list">
                                                    <a href="index.php" class="single">Home</a>
                                                </li>
                                                <li class="single-list">
                                                    <a href="about.php" class="single">About</a>
                                                </li>
                                                <li class="single-list">
                                                    <a href="destinations.php" class="single">Destination</a>
                                                </li>
                                                <li class="single-list">
                                                    <a href="tour-list.php" class="single">Tour Package</a>
                                                </li>
                                                <li class="single-list">
                                                    <a href="#" class="single">Visa</a>
                                                </li>
                                                <li class="single-list">
                                                    <a href="contact.php" class="single">Contact</a>
                                                </li>
                                            </ul>
                                            
                                            <div class="header-right">
                                                <div class="sign-btn d-flex gap-10">
                                                    <!-- <?php if(isset($_SESSION['username2'])) { ?>

                                                        <div class="profileScetion">
                                                            <div class="profilePic">
                                                                <img src="assets/images/hero/user-1.jpeg" alt="">
                                                            </div>

                                                            <div class="dropdown alignContent">
                                                                <button class="btn border-0 dropdown-toggle d-flex align-items-center" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                                    <div class="profileUserName text-black">
                                                                        <?php echo $_SESSION['username2']; ?>
                                                                    </div>
                                                                </button>

                                                                <ul class="dropdown-menu dropdown-menu-end p-2">

                                                                    <?php
                                                                        if(isset($_SESSION['user_id']) && isset($_SESSION['user_type_id_value'])){

                                                                            if($_SESSION['user_id'] == "CU260052" && $_SESSION['user_type_id_value'] == "10"){
                                                                                echo '<li class="d-flex"><i class="ri-dashboard-line align-content-center"></i><a class="dropdown-item" href="dashboard/customer_dashboard/customer_dashboard.php">Dashboard</a></li>';
                                                                            }
                                                                            else if($_SESSION['user_type_id_value'] == "33"){
                                                                                echo '<li class="d-flex"><i class="ri-dashboard-line align-content-center"></i><a class="dropdown-item" href="dashboard/institute_branch_manager/index.php">Dashboard</a></li>';
                                                                            }
                                                                            else if($_SESSION['user_type_id_value'] == "35"){
                                                                                echo '<li class="d-flex"><i class="ri-dashboard-line align-content-center"></i><a class="dropdown-item" href="dashboard/super_techno_enterprise/super_techno_dashboard.php">Dashboard</a></li>';
                                                                            }
                                                                            else if($_SESSION['user_type_id_value'] == "34"){
                                                                                echo '<li class="d-flex"><i class="ri-dashboard-line align-content-center"></i><a class="dropdown-item" href="dashboard/executive_techno_enterprise/executive_techno_dashboard.php">Dashboard</a></li>';
                                                                            }
                                                                            else if($_SESSION['user_type_id_value'] == "16"){
                                                                                echo '<li class="d-flex"><i class="ri-dashboard-line align-content-center"></i><a class="dropdown-item" href="dashboard/techno_enterprise/techno_dashboard.php">Dashboard</a></li>';
                                                                            }
                                                                            else if($_SESSION['user_type_id_value'] == "36"){
                                                                                echo '<li class="d-flex"><i class="ri-dashboard-line align-content-center"></i><a class="dropdown-item" href="dashboard/chief_techno_enterprise/chief_techno_dashboard.php">Dashboard</a></li>';
                                                                            }
                                                                            else if($_SESSION['user_type_id_value'] == "11"){
                                                                                echo '<li class="d-flex"><i class="ri-dashboard-line align-content-center"></i><a class="dropdown-item" href="dashboard/travel_consultant/travel_consultant_dashboard.php">Dashboard</a></li>';
                                                                            }
                                                                            else if($_SESSION['user_type_id_value'] == "29"){
                                                                                echo '<li class="d-flex"><i class="ri-dashboard-line align-content-center"></i><a class="dropdown-item" href="dashboard/franchisee/franchisee_dashboard.php">Dashboard</a></li>';
                                                                            }
                                                                            else if($_SESSION['user_type_id_value'] == "26"){
                                                                                echo '<li class="d-flex"><i class="ri-dashboard-line align-content-center"></i><a class="dropdown-item" href="dashboard/business_mentor/business_mentor_dashboard.php">Dashboard</a></li>';
                                                                            }
                                                                            else if($_SESSION['user_type_id_value'] == "30"){
                                                                                echo '<li class="d-flex"><i class="ri-dashboard-line align-content-center"></i><a class="dropdown-item" href="dashboard/sponsor_franchisee/sponsor_franchisee_dashboard.php">Dashboard</a></li>';
                                                                            }
                                                                            else if($_SESSION['user_type_id_value'] == "28"){
                                                                                echo '<li class="d-flex"><i class="ri-dashboard-line align-content-center"></i><a class="dropdown-item" href="dashboard/master_franchisee/master_franchisee_dashboard.php">Dashboard</a></li>';
                                                                            }
                                                                            else if($_SESSION['user_type_id_value'] == "25"){
                                                                                echo '<li class="d-flex"><i class="ri-dashboard-line align-content-center"></i><a class="dropdown-item" href="dashboard/business_development_manager/business_development_manager_dashboard.php">Dashboard</a></li>';
                                                                            }
                                                                            else{
                                                                                echo '<li class="d-flex"><i class="ri-dashboard-line align-content-center"></i><a class="dropdown-item" href="dashboard/">Dashboard</a></li>';
                                                                            }
                                                                        }
                                                                    ?>

                                                                    <li class="d-flex">
                                                                        <i class="ri-calendar-line align-content-center stickyTextBlack"></i>
                                                                        <a class="dropdown-item stickyTextBlack" href="#">
                                                                            My Bookings
                                                                        </a>
                                                                    </li>
                                                                    <li class="d-flex">
                                                                        <i class="ri-user-line align-content-center stickyTextBlack"></i>
                                                                        <a class="dropdown-item stickyTextBlack" href="login.php">
                                                                            My Profile
                                                                        </a>
                                                                    </li>
                                                                    <hr class="my-2 border border-black opacity-25">
                                                                    <li class="d-flex">
                                                                        <i class="ri-settings-5-line align-content-center stickyTextBlack"></i>
                                                                        <a class="dropdown-item stickyTextBlack" href="login.php">
                                                                            Settings
                                                                        </a>
                                                                    </li>
                                                                    <li class="d-flex">
                                                                        <i class="ri-logout-box-r-line align-content-center stickyTextBlack"></i>
                                                                        <a class="dropdown-item stickyTextBlack" href="login.php">
                                                                            Logout
                                                                        </a>
                                                                    </li>

                                                                </ul>
                                                            </div>
                                                        </div>

                                                        <?php } else { ?>

                                                        <a href="login.php" class="btn-secondary-sm my2logout d-flex justify-content-center align-items-center p-0" style="width:80px;height:40px;">
                                                            Log In
                                                        </a>
                                                    <?php } ?> -->
                                                    <?php if(isset($_SESSION['username2'])) { ?>

                                                        <div class="profileScetion">
                                                            <div class="profilePic">
                                                                <img src="uploading/<?= $_SESSION['profile_pic'] ?>" alt="">
                                                            </div>

                                                            <div class="dropdown alignContent">

                                                                <button class="btn border-0 dropdown-toggle d-flex align-items-center"
                                                                        type="button"
                                                                        data-bs-toggle="dropdown"
                                                                        aria-expanded="false">

                                                                    <div class="profileUserName text-black">
                                                                        <?php echo $_SESSION['username2']; ?>
                                                                    </div>

                                                                </button>

                                                                <ul class="dropdown-menu dropdown-menu-end p-2">

                                                                    <?php

                                                                    if(isset($_SESSION['user_id']) && isset($_SESSION['user_type_id_value'])){

                                                                        $userId   = $_SESSION['user_id'];
                                                                        $userType = $_SESSION['user_type_id_value'];

                                                                        // Default values
                                                                        $dashboardLink = "dashboard/";
                                                                        $dashboardFolder = "dashboard";

                                                                        if($userId == "CU260052" && $userType == "10"){

                                                                            $dashboardLink = "dashboard/customer_dashboard/customer_dashboard.php";
                                                                            $dashboardFolder = "dashboard/customer_dashboard";

                                                                        }
                                                                        else if($userType == "33"){

                                                                            $dashboardLink = "dashboard/institute_branch_manager/index.php";
                                                                            $dashboardFolder = "dashboard/institute_branch_manager";

                                                                        }
                                                                        else if($userType == "35"){

                                                                            $dashboardLink = "dashboard/super_techno_enterprise/super_techno_dashboard.php";
                                                                            $dashboardFolder = "dashboard/super_techno_enterprise";

                                                                        }
                                                                        else if($userType == "34"){

                                                                            $dashboardLink = "dashboard/executive_techno_enterprise/executive_techno_dashboard.php";
                                                                            $dashboardFolder = "dashboard/executive_techno_enterprise";

                                                                        }
                                                                        else if($userType == "16"){

                                                                            $dashboardLink = "dashboard/techno_enterprise/techno_dashboard.php";
                                                                            $dashboardFolder = "dashboard/techno_enterprise";

                                                                        }
                                                                        else if($userType == "36"){

                                                                            $dashboardLink = "dashboard/chief_techno_enterprise/chief_techno_dashboard.php";
                                                                            $dashboardFolder = "dashboard/chief_techno_enterprise";

                                                                        }
                                                                        else if($userType == "11"){

                                                                            $dashboardLink = "dashboard/travel_consultant/travel_consultant_dashboard.php";
                                                                            $dashboardFolder = "dashboard/travel_consultant";

                                                                        }
                                                                        else if($userType == "29"){

                                                                            $dashboardLink = "dashboard/franchisee/franchisee_dashboard.php";
                                                                            $dashboardFolder = "dashboard/franchisee";

                                                                        }
                                                                        else if($userType == "26"){

                                                                            $dashboardLink = "dashboard/business_mentor/business_mentor_dashboard.php";
                                                                            $dashboardFolder = "dashboard/business_mentor";

                                                                        }
                                                                        else if($userType == "30"){

                                                                            $dashboardLink = "dashboard/sponsor_franchisee/sponsor_franchisee_dashboard.php";
                                                                            $dashboardFolder = "dashboard/sponsor_franchisee";

                                                                        }
                                                                        else if($userType == "28"){

                                                                            $dashboardLink = "dashboard/master_franchisee/master_franchisee_dashboard.php";
                                                                            $dashboardFolder = "dashboard/master_franchisee";

                                                                        }
                                                                        else if($userType == "25"){

                                                                            $dashboardLink = "dashboard/business_development_manager/business_development_manager_dashboard.php";
                                                                            $dashboardFolder = "dashboard/business_development_manager";

                                                                        }
                                                                        else{

                                                                            $dashboardLink = "dashboard/";
                                                                            $dashboardFolder = "dashboard";

                                                                        }

                                                                    ?>

                                                                        <!-- Dashboard -->
                                                                        <li class="d-flex">
                                                                            <i class="ri-dashboard-line align-content-center"></i>
                                                                            <a class="dropdown-item" href="<?php echo $dashboardLink; ?>">
                                                                                Dashboard
                                                                            </a>
                                                                        </li>


                                                                        <!-- My Bookings -->
                                                                        <li class="d-flex">
                                                                            <i class="ri-calendar-line align-content-center stickyTextBlack"></i>
                                                                            <a class="dropdown-item stickyTextBlack"
                                                                            href="<?php echo $dashboardFolder; ?>/order_details.php">
                                                                                My Bookings
                                                                            </a>
                                                                        </li>


                                                                        <!-- My Profile -->
                                                                        <li class="d-flex">
                                                                            <i class="ri-user-line align-content-center stickyTextBlack"></i>
                                                                            <a class="dropdown-item stickyTextBlack"
                                                                            href="<?php echo $dashboardFolder; ?>/profile.php">
                                                                                My Profile
                                                                            </a>
                                                                        </li>


                                                                        <hr class="my-2 border border-black opacity-25">


                                                                        <!-- Settings -->
                                                                        <!-- <li class="d-flex">
                                                                            <i class="ri-settings-5-line align-content-center stickyTextBlack"></i>
                                                                            <a class="dropdown-item stickyTextBlack"
                                                                            href="<?php echo $dashboardFolder; ?>/settings.php">
                                                                                Settings
                                                                            </a>
                                                                        </li> -->


                                                                        <!-- Logout -->
                                                                        <li class="d-flex">
                                                                            <i class="ri-logout-box-r-line align-content-center stickyTextBlack"></i>
                                                                            <a class="dropdown-item stickyTextBlack"
                                                                            href="dashboard/logout.php">
                                                                                Logout
                                                                            </a>
                                                                        </li>

                                                                    <?php
                                                                    }
                                                                    ?>

                                                                </ul>
                                                            </div>
                                                        </div>

                                                    <?php } else { ?>

                                                        <a href="login.php"
                                                        class="btn-secondary-sm my2logout d-flex justify-content-center align-items-center p-0"
                                                        style="width:80px;height:40px;">
                                                            Log In
                                                        </a>

                                                    <?php } ?>
                                                </div>
                                                <!-- Theme Mode -->
                                                <li class="single-list">
                                                    <button class="ToggleThemeButton change-theme-mode m-0 p-0 border-0">
                                                        <i class="ri-sun-line"></i>
                                                    </button>
                                                </li>
                                            </div>
                                        </div>
                                    </nav>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Mobile Header Right -->
                    <div class="mobile-header-right d-flex d-lg-none ms-auto">

                        <?php if(isset($_SESSION['username2'])): ?>
                            <div class="dropdown me-2">
                                <div class="profilePic mobileProfile1" data-bs-toggle="dropdown" aria-expanded="false">
                                    <img src="uploading/<?= $_SESSION['profile_pic'] ?>" alt="">
                                </div>

                                <ul class="dropdown-menu dropdown-menu-end px-3">

                                    <?php

                                        if (isset($_SESSION['user_id']) && isset($_SESSION['user_type_id_value'])) {

                                            $userId   = $_SESSION['user_id'];
                                            $userType = $_SESSION['user_type_id_value'];

                                            // Default dashboard folder
                                            $dashboardFolder = "dashboard";

                                            if ($userId == "CU260052" && $userType == "10") {
                                                $dashboardFolder = "dashboard/customer_dashboard";
                                            }
                                            else if ($userType == "33") {
                                                $dashboardFolder = "dashboard/institute_branch_manager";
                                            }
                                            else if ($userType == "35") {
                                                $dashboardFolder = "dashboard/super_techno_enterprise";
                                            }
                                            else if ($userType == "34") {
                                                $dashboardFolder = "dashboard/executive_techno_enterprise";
                                            }
                                            else if ($userType == "16") {
                                                $dashboardFolder = "dashboard/techno_enterprise";
                                            }
                                            else if ($userType == "36") {
                                                $dashboardFolder = "dashboard/chief_techno_enterprise";
                                            }
                                            else if ($userType == "11") {
                                                $dashboardFolder = "dashboard/travel_consultant";
                                            }
                                            else if ($userType == "29") {
                                                $dashboardFolder = "dashboard/franchisee";
                                            }
                                            else if ($userType == "26") {
                                                $dashboardFolder = "dashboard/business_mentor";
                                            }
                                            else if ($userType == "30") {
                                                $dashboardFolder = "dashboard/sponsor_franchisee";
                                            }
                                            else if ($userType == "28") {
                                                $dashboardFolder = "dashboard/master_franchisee";
                                            }
                                            else if ($userType == "25") {
                                                $dashboardFolder = "dashboard/business_development_manager";
                                            }

                                            // Dashboard page
                                            $dashboardLink = $dashboardFolder . "/index.php";

                                            // Profile page
                                            $profileLink = $dashboardFolder . "/profile.php";

                                            // Order / booking details page
                                            $orderDetailsLink = $dashboardFolder . "/order_details.php";
                                    ?>

                                        <!-- Dashboard -->
                                        <li class="d-flex">
                                            <i class="ri-dashboard-line align-content-center"></i>
                                            <a class="dropdown-item" href="<?php echo $dashboardLink; ?>">
                                                Dashboard
                                            </a>
                                        </li>

                                        <!-- My Bookings -->
                                        <li class="d-flex">
                                            <i class="ri-calendar-line align-content-center stickyTextBlack"></i>
                                            <a class="dropdown-item stickyTextBlack" href="<?php echo $orderDetailsLink; ?>">
                                                My Bookings
                                            </a>
                                        </li>

                                        <!-- My Profile -->
                                        <li class="d-flex">
                                            <i class="ri-user-line align-content-center stickyTextBlack"></i>
                                            <a class="dropdown-item stickyTextBlack" href="<?php echo $profileLink; ?>">
                                                My Profile
                                            </a>
                                        </li>

                                        <hr class="my-2 border border-black opacity-25">

                                        <!-- Settings -->
                                        <li class="d-flex">
                                            <i class="ri-settings-5-line align-content-center stickyTextBlack"></i>
                                            <a class="dropdown-item stickyTextBlack" href="<?php echo $dashboardFolder; ?>/settings.php">
                                                Settings
                                            </a>
                                        </li>

                                        <!-- Logout -->
                                        <li class="d-flex">
                                            <i class="ri-logout-box-r-line align-content-center stickyTextBlack"></i>
                                            <a class="dropdown-item stickyTextBlack" href="dashboard/logout.php">
                                                Logout
                                            </a>
                                        </li>

                                        <?php
                                        } 
                                        ?>
                                    
                                </ul>
                            </div>

                        <?php else :?>

                        <a href="login.php"
                        class="btn-secondary-sm my2logout d-flex justify-content-center align-items-center p-0"
                        style="width:80px;height:40px;">
                            Log In
                        </a>

                        <?php endif;?>

                        <div class="mobile_menu"></div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</header>