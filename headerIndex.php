<header class="header-area-three">
    <div class="main-header">
        <div class="header-bottom header-sticky">
            <div class="row mx-2 pt-2">
                <div class="col-xl-1 col-lg-1 heroCard">
                    <!-- Logo-->
                    <div class="logo">
                        <a href="index.php"><img src="assets/images/bizz_logo.png" alt="logo" height="55px" width="80px"></a>
                    </div>
                </div>
                <div class="col-xl-8 col-lg-8">
                    <div class="menu-wrapper">
                        <!-- Main-menu for desktop -->
                        <div class="main-menu d-none d-lg-block">
                            <nav>
                                <ul class="listing" id="navigation">
                                    <li class="single-list">
                                        <a href="index.php" class="single">Home </a>
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
                                    <!-- add session -->
                                    <?php if(!isset($_SESSION['username2'])) { ?>
                                    <div class="stickyBtnDisplay">
                                        <div class="d-flex align-items-center gap-2">
                                            <!-- Wishlist -->
                                            <a type="button" class="wishlistHeaderBtn1 btn btn-outline-light radius-30 text-white my2logout fw-bolder d-flex justify-content-center align-items-center" data-bs-toggle="offcanvas" data-bs-target="#wishlistOffcanvas" aria-controls="wishlistOffcanvas">
                                                <i class="ri-heart-line"></i>
                                                <span class="wishlistCount">0</span>
                                            </a>

                                            <!-- Login -->
                                            <a href="login.php" class="loginBtn1 btn btn-outline-light radius-30 text-white my2logout fw-bolder d-flex justify-content-center align-items-center">
                                                Log In
                                            </a>
                                        </div>
                                    </div>
                                    <?php } ?>
                                    <!-- end add session -->
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-3 col-12 d-flex justify-content-end align-items-center heroCard">
                    <!-- Top Left Side -->
                    <div class="header-right-three pl-15 d-none d-lg-flex">
                        <div class="d-flex gap-10 align-items-center">
                            <div class="sign-btn d-flex gap-10">
                                <!-- <?php if(isset($_SESSION['username2'])) { ?>

                                    <div class="profileScetion">
                                        <div class="profilePic">
                                            <img src="assets/images/hero/user-1.jpeg" alt="">
                                        </div>

                                        <div class="dropdown alignContent">
                                            <button class="btn border-0 dropdown-toggle d-flex align-items-center" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                <div class="profileUserName">
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

                                    <a href="login.php" class="btn btn-outline-light radius-30 text-white my2logout fw-bolder d-flex justify-content-center align-items-center" style="width:80px;height:40px;">
                                        Log In
                                    </a>
                                <?php } ?> -->
                                <?php if(isset($_SESSION['username2'])) { ?>

                                    <div class="profileScetion">
                                        <div class="profilePic">
                                            <img src="uploading/<?= $_SESSION['profile_pic'] ?>" alt="">
                                        </div>

                                        <div class="dropdown alignContent">
                                            <button class="btn border-0 dropdown-toggle d-flex align-items-center" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                <div class="profileUserName">
                                                    <?php echo $_SESSION['username2']; ?>
                                                </div>
                                            </button>

                                            <ul class="dropdown-menu dropdown-menu-end p-2">

                                                <?php
                                                    if(isset($_SESSION['user_id']) && isset($_SESSION['user_type_id_value'])){

                                                        $userId   = $_SESSION['user_id'];
                                                        $userType = $_SESSION['user_type_id_value'];

                                                        // Default dashboard folder
                                                        $dashboardFolder = "dashboard";

                                                        if( $userType == "10"){
                                                            if ($_SESSION['customer_type'] == 'Neo Select') {
                                                                $dashboardFolder = "dashboard/customer_dashboard";

                                                                echo '<li class="d-flex">
                                                                        <i class="ri-dashboard-line align-content-center"></i>
                                                                        <a class="dropdown-item" href="' . $dashboardFolder . '/customer_dashboard.php">
                                                                            Dashboard
                                                                        </a>
                                                                    </li>';
                                                            }else{
                                                                $dashboardFolder = "dashboard/";

                                                                echo '<li class="d-flex">
                                                                        <i class="ri-dashboard-line align-content-center"></i>
                                                                        <a class="dropdown-item" href="' . $dashboardFolder . 'index.php">
                                                                            Dashboard
                                                                        </a>
                                                                    </li>';
                                                            }
                                                            

                                                        }
                                                        else if($userType == "33"){

                                                            $dashboardFolder = "dashboard/institute_branch_manager";

                                                            echo '<li class="d-flex">
                                                                    <i class="ri-dashboard-line align-content-center"></i>
                                                                    <a class="dropdown-item" href="' . $dashboardFolder . '/index.php">
                                                                        Dashboard
                                                                    </a>
                                                                </li>';

                                                        }
                                                        else if($userType == "35"){

                                                            $dashboardFolder = "dashboard/super_techno_enterprise";

                                                            echo '<li class="d-flex">
                                                                    <i class="ri-dashboard-line align-content-center"></i>
                                                                    <a class="dropdown-item" href="' . $dashboardFolder . '/super_techno_dashboard.php">
                                                                        Dashboard
                                                                    </a>
                                                                </li>';

                                                        }
                                                        else if($userType == "34"){

                                                            $dashboardFolder = "dashboard/executive_techno_enterprise";

                                                            echo '<li class="d-flex">
                                                                    <i class="ri-dashboard-line align-content-center"></i>
                                                                    <a class="dropdown-item" href="' . $dashboardFolder . '/executive_techno_dashboard.php">
                                                                        Dashboard
                                                                    </a>
                                                                </li>';

                                                        }
                                                        else if($userType == "16"){

                                                            $dashboardFolder = "dashboard/techno_enterprise";

                                                            echo '<li class="d-flex">
                                                                    <i class="ri-dashboard-line align-content-center"></i>
                                                                    <a class="dropdown-item" href="' . $dashboardFolder . '/techno_dashboard.php">
                                                                        Dashboard
                                                                    </a>
                                                                </li>';

                                                        }
                                                        else if($userType == "36"){

                                                            $dashboardFolder = "dashboard/chief_techno_enterprise";

                                                            echo '<li class="d-flex">
                                                                    <i class="ri-dashboard-line align-content-center"></i>
                                                                    <a class="dropdown-item" href="' . $dashboardFolder . '/chief_techno_dashboard.php">
                                                                        Dashboard
                                                                    </a>
                                                                </li>';

                                                        }
                                                        else if($userType == "11"){

                                                            $dashboardFolder = "dashboard/travel_consultant";

                                                            echo '<li class="d-flex">
                                                                    <i class="ri-dashboard-line align-content-center"></i>
                                                                    <a class="dropdown-item" href="' . $dashboardFolder . '/travel_consultant_dashboard.php">
                                                                        Dashboard
                                                                    </a>
                                                                </li>';

                                                        }
                                                        else if($userType == "29"){

                                                            $dashboardFolder = "dashboard/franchisee";

                                                            echo '<li class="d-flex">
                                                                    <i class="ri-dashboard-line align-content-center"></i>
                                                                    <a class="dropdown-item" href="' . $dashboardFolder . '/franchisee_dashboard.php">
                                                                        Dashboard
                                                                    </a>
                                                                </li>';

                                                        }
                                                        else if($userType == "26"){

                                                            $dashboardFolder = "dashboard/business_mentor";

                                                            echo '<li class="d-flex">
                                                                    <i class="ri-dashboard-line align-content-center"></i>
                                                                    <a class="dropdown-item" href="' . $dashboardFolder . '/business_mentor_dashboard.php">
                                                                        Dashboard
                                                                    </a>
                                                                </li>';

                                                        }
                                                        else if($userType == "30"){

                                                            $dashboardFolder = "dashboard/sponsor_franchisee";

                                                            echo '<li class="d-flex">
                                                                    <i class="ri-dashboard-line align-content-center"></i>
                                                                    <a class="dropdown-item" href="' . $dashboardFolder . '/sponsor_franchisee_dashboard.php">
                                                                        Dashboard
                                                                    </a>
                                                                </li>';

                                                        }
                                                        else if($userType == "28"){

                                                            $dashboardFolder = "dashboard/master_franchisee";

                                                            echo '<li class="d-flex">
                                                                    <i class="ri-dashboard-line align-content-center"></i>
                                                                    <a class="dropdown-item" href="' . $dashboardFolder . '/master_franchisee_dashboard.php">
                                                                        Dashboard
                                                                    </a>
                                                                </li>';

                                                        }
                                                        else if($userType == "25"){

                                                            $dashboardFolder = "dashboard/business_development_manager";

                                                            echo '<li class="d-flex">
                                                                    <i class="ri-dashboard-line align-content-center"></i>
                                                                    <a class="dropdown-item" href="' . $dashboardFolder . '/business_development_manager_dashboard.php">
                                                                        Dashboard
                                                                    </a>
                                                                </li>';

                                                        }
                                                        else{

                                                            $dashboardFolder = "dashboard";

                                                            echo '<li class="d-flex">
                                                                    <i class="ri-dashboard-line align-content-center"></i>
                                                                    <a class="dropdown-item" href="' . $dashboardFolder . '/">
                                                                        Dashboard
                                                                    </a>
                                                                </li>';
                                                        }
                                                    }
                                                ?>

                                                <li class="d-flex">
                                                    <i class="ri-calendar-line align-content-center stickyTextBlack"></i>
                                                    <a class="dropdown-item stickyTextBlack" href="<?php echo $dashboardFolder; ?>/order_history.php">
                                                        My Bookings
                                                    </a>
                                                </li>

                                                <li class="d-flex">
                                                    <i class="ri-user-line align-content-center stickyTextBlack"></i>
                                                    <a class="dropdown-item stickyTextBlack" href="<?php echo $dashboardFolder; ?>/profile.php">
                                                        My Profile
                                                    </a>
                                                </li>

                                                <hr class="my-2 border border-black opacity-25">

                                                <li class="d-flex">
                                                    <i class="ri-heart-line align-content-center stickyTextBlack"></i>
                                                    <a class="dropdown-item stickyTextBlack" data-bs-toggle="offcanvas" data-bs-target="#wishlistOffcanvas" aria-controls="wishlistOffcanvas">
                                                        My Wishlist
                                                        <span class="wishlistCount ms-1">0</span>
                                                    </a>
                                                </li>
                                                <li class="d-flex">
                                                    <i class="ri-logout-box-r-line align-content-center stickyTextBlack"></i>
                                                    <a class="dropdown-item stickyTextBlack" href="dashboard/logout.php">
                                                        Logout
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>

                                <?php } else { ?>

                                    <div class="d-flex align-items-center gap-2">

                                        <!-- Wishlist -->
                                        <a type="button" class="wishlistHeaderBtn btn btn-outline-light radius-30 text-white my2logout fw-bolder" data-bs-toggle="offcanvas" data-bs-target="#wishlistOffcanvas" aria-controls="wishlistOffcanvas">
                                            <i class="ri-heart-line"></i>
                                            <span class="wishlistCount">0</span>
                                        </a>

                                        <!-- Login -->
                                        <a href="login.php" class="btn btn-outline-light radius-30 text-white my2logout fw-bolder d-flex justify-content-center align-items-center" style="width:80px;height:40px;">
                                            Log In
                                        </a>

                                    </div>

                                <?php } ?>
                            </div>
                            <!-- Theme Mode -->
                            <button class="ToggleThemeButton change-theme-mode m-0 p-0 border-0 text-white">
                                <i class="ri-sun-line"></i>
                            </button>
                        </div>
                    </div>
                    <!-- Mobile Right Section -->
                    <div class="d-flex d-lg-none gap-2">
                        <?php if(isset($_SESSION['username2'])): ?>

                            <div class="dropdown">
                                <div class="profilePic mobileProfile" data-bs-toggle="dropdown" aria-expanded="false">
                                    <img src="uploading/<?= $_SESSION['profile_pic'] ?>" alt="">
                                </div>

                                <ul class="dropdown-menu dropdown-menu-end px-3">

                                    <?php
                                        if(isset($_SESSION['user_id']) && isset($_SESSION['user_type_id_value'])){

                                            $userId   = $_SESSION['user_id'];
                                            $userType = $_SESSION['user_type_id_value'];

                                            // Default dashboard folder
                                            $dashboardFolder = "dashboard";

                                            if( $userType == "10"){
                                                if ($_SESSION['customer_type'] == 'Neo Select') {
                                                    $dashboardFolder = "dashboard/customer_dashboard";

                                                    echo '<li class="d-flex">
                                                            <i class="ri-dashboard-line align-content-center"></i>
                                                            <a class="dropdown-item" href="' . $dashboardFolder . '/customer_dashboard.php">
                                                                Dashboard
                                                            </a>
                                                        </li>';
                                                }else{
                                                    $dashboardFolder = "dashboard/";

                                                    echo '<li class="d-flex">
                                                            <i class="ri-dashboard-line align-content-center"></i>
                                                            <a class="dropdown-item" href="' . $dashboardFolder . 'index.php">
                                                                Dashboard
                                                            </a>
                                                        </li>';
                                                }
                                                

                                            }
                                            else if($userType == "33"){

                                                $dashboardFolder = "dashboard/institute_branch_manager";

                                                echo '<li class="d-flex">
                                                        <i class="ri-dashboard-line align-content-center"></i>
                                                        <a class="dropdown-item" href="dashboard/institute_branch_manager/index.php">
                                                            Dashboard
                                                        </a>
                                                    </li>';

                                            }
                                            else if($userType == "35"){

                                                $dashboardFolder = "dashboard/super_techno_enterprise";

                                                echo '<li class="d-flex">
                                                        <i class="ri-dashboard-line align-content-center"></i>
                                                        <a class="dropdown-item" href="dashboard/super_techno_enterprise/super_techno_dashboard.php">
                                                            Dashboard
                                                        </a>
                                                    </li>';

                                            }
                                            else if($userType == "34"){

                                                $dashboardFolder = "dashboard/executive_techno_enterprise";

                                                echo '<li class="d-flex">
                                                        <i class="ri-dashboard-line align-content-center"></i>
                                                        <a class="dropdown-item" href="dashboard/executive_techno_enterprise/executive_techno_dashboard.php">
                                                            Dashboard
                                                        </a>
                                                    </li>';

                                            }
                                            else if($userType == "16"){

                                                $dashboardFolder = "dashboard/techno_enterprise";

                                                echo '<li class="d-flex">
                                                        <i class="ri-dashboard-line align-content-center"></i>
                                                        <a class="dropdown-item" href="dashboard/techno_enterprise/techno_dashboard.php">
                                                            Dashboard
                                                        </a>
                                                    </li>';

                                            }
                                            else if($userType == "36"){

                                                $dashboardFolder = "dashboard/chief_techno_enterprise";

                                                echo '<li class="d-flex">
                                                        <i class="ri-dashboard-line align-content-center"></i>
                                                        <a class="dropdown-item" href="dashboard/chief_techno_enterprise/chief_techno_dashboard.php">
                                                            Dashboard
                                                        </a>
                                                    </li>';

                                            }
                                            else if($userType == "11"){

                                                $dashboardFolder = "dashboard/travel_consultant";

                                                echo '<li class="d-flex">
                                                        <i class="ri-dashboard-line align-content-center"></i>
                                                        <a class="dropdown-item" href="dashboard/travel_consultant/travel_consultant_dashboard.php">
                                                            Dashboard
                                                        </a>
                                                    </li>';

                                            }
                                            else if($userType == "29"){

                                                $dashboardFolder = "dashboard/franchisee";

                                                echo '<li class="d-flex">
                                                        <i class="ri-dashboard-line align-content-center"></i>
                                                        <a class="dropdown-item" href="dashboard/franchisee/franchisee_dashboard.php">
                                                            Dashboard
                                                        </a>
                                                    </li>';

                                            }
                                            else if($userType == "26"){

                                                $dashboardFolder = "dashboard/business_mentor";

                                                echo '<li class="d-flex">
                                                        <i class="ri-dashboard-line align-content-center"></i>
                                                        <a class="dropdown-item" href="dashboard/business_mentor/business_mentor_dashboard.php">
                                                            Dashboard
                                                        </a>
                                                    </li>';

                                            }
                                            else if($userType == "30"){

                                                $dashboardFolder = "dashboard/sponsor_franchisee";

                                                echo '<li class="d-flex">
                                                        <i class="ri-dashboard-line align-content-center"></i>
                                                        <a class="dropdown-item" href="dashboard/sponsor_franchisee/sponsor_franchisee_dashboard.php">
                                                            Dashboard
                                                        </a>
                                                    </li>';

                                            }
                                            else if($userType == "28"){

                                                $dashboardFolder = "dashboard/master_franchisee";

                                                echo '<li class="d-flex">
                                                        <i class="ri-dashboard-line align-content-center"></i>
                                                        <a class="dropdown-item" href="dashboard/master_franchisee/master_franchisee_dashboard.php">
                                                            Dashboard
                                                        </a>
                                                    </li>';

                                            }
                                            else if($userType == "25"){

                                                $dashboardFolder = "dashboard/business_development_manager";

                                                echo '<li class="d-flex">
                                                        <i class="ri-dashboard-line align-content-center"></i>
                                                        <a class="dropdown-item" href="dashboard/business_development_manager/business_development_manager_dashboard.php">
                                                            Dashboard
                                                        </a>
                                                    </li>';

                                            }
                                            else{

                                                $dashboardFolder = "dashboard";

                                                echo '<li class="d-flex">
                                                        <i class="ri-dashboard-line align-content-center"></i>
                                                        <a class="dropdown-item" href="dashboard/">
                                                            Dashboard
                                                        </a>
                                                    </li>';
                                            }
                                        }
                                    ?>

                                    <li class="d-flex">
                                        <i class="ri-calendar-line align-content-center stickyTextBlack"></i>
                                        <a class="dropdown-item stickyTextBlack" href="<?php echo $dashboardFolder; ?>/order_history.php">
                                            My Bookings
                                        </a>
                                    </li>

                                    <li class="d-flex">
                                        <i class="ri-user-line align-content-center stickyTextBlack"></i>
                                        <a class="dropdown-item stickyTextBlack" href="<?php echo $dashboardFolder; ?>/profile.php">
                                            My Profile
                                        </a>
                                    </li>

                                    <hr class="my-2 border border-black opacity-25">

                                    <!-- Wishlist -->
                                    <li class="d-flex">
                                        <i class="ri-heart-line align-content-center stickyTextBlack"></i>
                                        <a class="dropdown-item stickyTextBlack" data-bs-toggle="offcanvas" data-bs-target="#wishlistOffcanvas" aria-controls="wishlistOffcanvas">
                                            My Wishlist
                                            <span class="wishlistCount ms-1">0</span>
                                        </a>
                                    </li>

                                    <li class="d-flex">
                                        <i class="ri-logout-box-r-line align-content-center stickyTextBlack"></i>
                                        <a class="dropdown-item stickyTextBlack" href="dashboard/logout.php">
                                            Logout
                                        </a>
                                    </li>

                                </ul>
                            </div>

                        <?php endif; ?>
                        <div class="mobile_menu mt-2"></div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
<?php include __DIR__ . '/wishlist_offcanvas.php'; ?>
<?php

$isLoggedIn = !empty($_SESSION['username2']);

?>
<script>
    const isWishlistUserLoggedIn =<?= $isLoggedIn ? 'true' : 'false' ?>;
</script>
<script src="assets/js/wishlist.js"></script>