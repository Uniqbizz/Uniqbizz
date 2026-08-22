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
                                                <!-- add session -->
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
                                                <!-- end add session -->
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
                                                                            href="<?php echo $dashboardFolder; ?>/order_history.php">
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


                                                                        <!-- Wishlist -->
                                                                        <li class="d-flex">
                                                                            <i class="ri-heart-line align-content-center stickyTextBlack"></i>
                                                                            <button type="button" class="dropdown-item stickyTextBlack" data-bs-toggle="offcanvas" data-bs-target="#wishlistOffcanvas" aria-controls="wishlistOffcanvas">
                                                                                My Wishlist
                                                                                <span class="wishlistCount ms-1">0</span>
                                                                            </button>
                                                                        </li>


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

                                                        <div class="d-flex align-items-center gap-2">

                                                            <!-- Wishlist -->
                                                            <button type="button" class="wishlistHeaderBtn btn-secondary-sm " data-bs-toggle="offcanvas" data-bs-target="#wishlistOffcanvas" aria-controls="wishlistOffcanvas">
                                                                <i class="ri-heart-line"></i>
                                                                <span class="wishlistCount">0</span>
                                                            </button>

                                                            <!-- Login -->
                                                            <a href="login.php" class="btn-secondary-sm my2logout d-flex justify-content-center align-items-center p-0" style="width:80px;height:40px;">
                                                                Log In
                                                            </a>
                                                        </div>

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
                                            $orderDetailsLink = $dashboardFolder . "/order_history.php";
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

                                    <li class="d-flex">
                                        <i class="ri-heart-line align-content-center stickyTextBlack"></i>
                                        <button type="button" class="dropdown-item stickyTextBlack" data-bs-toggle="offcanvas" data-bs-target="#wishlistOffcanvas" aria-controls="wishlistOffcanvas">
                                            My Wishlist
                                            <span class="wishlistCount ms-1">0</span>
                                        </button>
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
                            
                        <?php endif;?>

                        <div class="mobile_menu"></div>

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
    const isWishlistUserLoggedIn =
        <?= $isLoggedIn ? 'true' : 'false' ?>;
    /* =========================================================
    WISHLIST SYSTEM
    ========================================================= */


    /* =========================================================
    GET WISHLIST FROM LOCAL STORAGE
    ========================================================= */

    function getWishlist() {

        try {

            const stored =
                localStorage.getItem('wishlist');

            if (!stored) {
                return [];
            }

            const wishlist =
                JSON.parse(stored);

            if (!Array.isArray(wishlist)) {
                return [];
            }

            return [...new Set(
                wishlist
                    .map(id => String(id).trim())
                    .filter(id => id !== '')
            )];

        } catch (error) {

            // console.error(
            //     'WISHLIST: localStorage error',
            //     error
            // );

            return [];
        }
    }
    //db data
    async function loadWishlistFromDB() {

        if (!isWishlistUserLoggedIn) {
            return [];
        }

        try {

            const response =
                await fetch(
                    'assets/submit/get_user_wishlist.php',
                    {
                        method: 'POST',
                        cache: 'no-store'
                    }
                );


            if (!response.ok) {

                throw new Error(
                    `HTTP ${response.status}`
                );
            }


            const result =
                await response.json();


            if (
                !result ||
                result.status !== true ||
                !Array.isArray(result.data)
            ) {

                return [];
            }


            return [
                ...new Set(
                    result.data
                        .map(id => String(id).trim())
                        .filter(id => id !== '')
                )
            ];

        } catch (error) {

            return [];
        }
    }
    //sync
    async function syncWishlistWithDB() {

        if (!isWishlistUserLoggedIn) {
            return;
        }


        const localWishlist =
            getWishlist();


        const dbWishlist =
            await loadWishlistFromDB();


        const mergedWishlist =
            [
                ...new Set([
                    ...localWishlist,
                    ...dbWishlist
                ])
            ];


        saveWishlist(
            mergedWishlist
        );
    }

    /* =========================================================
    SAVE WISHLIST
    ========================================================= */

    function saveWishlist(wishlist) {

        if (!Array.isArray(wishlist)) {
            wishlist = [];
        }

        wishlist = [...new Set(
            wishlist
                .map(id => String(id).trim())
                .filter(id => id !== '')
        )];

        localStorage.setItem(
            'wishlist',
            JSON.stringify(wishlist)
        );

        updateWishlistCount();
    }


    /* =========================================================
    UPDATE WISHLIST COUNT
    ========================================================= */

    function updateWishlistCount() {

        const count =
            getWishlist().length;

        document
            .querySelectorAll('.wishlistCount')
            .forEach(element => {

                element.textContent = count;

            });
    }


    /* =========================================================
    UPDATE HEART BUTTON
    ========================================================= */

    function updateWishlistButton(button, active) {

        if (!button) {
            return;
        }

        const icon =
            button.querySelector('i');

        if (!icon) {
            return;
        }

        if (active) {

            button.classList.add('active');

            icon.classList.remove(
                'ri-heart-line'
            );

            icon.classList.add(
                'ri-heart-fill'
            );

        } else {

            button.classList.remove('active');

            icon.classList.remove(
                'ri-heart-fill'
            );

            icon.classList.add(
                'ri-heart-line'
            );
        }
    }


    /* =========================================================
    LOAD HEART STATES
    ========================================================= */

    function loadWishlistHeartState() {

        const wishlist =
            getWishlist();

        document
            .querySelectorAll('.wishlist-icon')
            .forEach(button => {

                const packageId =
                    String(
                        button.dataset.packageId || ''
                    ).trim();

                if (!packageId) {
                    return;
                }

                updateWishlistButton(
                    button,
                    wishlist.includes(packageId)
                );

            });
    }


    /* =========================================================
    EMPTY WISHLIST HTML
    ========================================================= */

    function getEmptyWishlistHTML() {

        return `

            <div class="text-center py-5">

                <i class="ri-heart-line text-muted"
                   style="font-size:60px;">
                </i>

                <h5 class="fw-bold mt-3">
                    Your Wishlist is Empty
                </h5>

                <p class="text-muted">
                    Start adding packages you love!
                </p>

            </div>

        `;
    }


    /* =========================================================
    LOADING HTML
    ========================================================= */

    function getWishlistLoadingHTML() {

        return `

            <div class="text-center py-5">

                <div class="spinner-border"
                     role="status">
                </div>

                <p class="text-muted mt-2 mb-0">
                    Loading wishlist...
                </p>

            </div>

        `;
    }


    /* =========================================================
    ERROR HTML
    ========================================================= */

    function getWishlistErrorHTML() {

        return `

            <div class="text-center py-5">

                <i class="ri-error-warning-line text-danger"
                style="font-size:50px;">
                </i>

                <h6 class="fw-bold mt-3">
                    Unable to load wishlist
                </h6>

                <p class="text-muted mb-0">
                    Please try again.
                </p>

            </div>

        `;
    }


    /* =========================================================
    LOAD WISHLIST ITEMS
    ========================================================= */

    async function loadWishlistItems() {

        // console.log(
        //     'WISHLIST: Loading wishlist...'
        // );


        const container =
            document.getElementById(
                'wishlistItems'
            );


        /* -------------------------------------------------------
        CHECK CONTAINER
        ------------------------------------------------------- */

        // if (!container) {

        //     console.error(
        //         'WISHLIST ERROR: #wishlistItems not found'
        //     );

        //     return;
        // }


        /* -------------------------------------------------------
        GET IDS
        ------------------------------------------------------- */

        const wishlist =
            getWishlist();


        // console.log(
        //     'WISHLIST IDs:',
        //     wishlist
        // );


        /* -------------------------------------------------------
        EMPTY
        ------------------------------------------------------- */

        if (wishlist.length === 0) {

            container.innerHTML =
                getEmptyWishlistHTML();

            return;
        }


        /* -------------------------------------------------------
        LOADING
        ------------------------------------------------------- */

        container.innerHTML =
            getWishlistLoadingHTML();


        /* -------------------------------------------------------
        SEND IDS TO PHP
        ------------------------------------------------------- */

        const formData =
            new FormData();


        formData.append(
            'package_ids',
            JSON.stringify(wishlist)
        );


        // console.log(
        //     'WISHLIST: Sending to PHP:',
        //     wishlist
        // );


        try {

            const response =
                await fetch(
                    'assets/submit/get_wishlist.php',
                    {
                        method: 'POST',
                        body: formData,
                        cache: 'no-store'
                    }
                );


            // console.log(
            //     'WISHLIST: HTTP:',
            //     response.status
            // );


            /* ---------------------------------------------------
            HTTP ERROR
            --------------------------------------------------- */

            if (!response.ok) {

                throw new Error(
                    `HTTP ${response.status}`
                );
            }


            /* ---------------------------------------------------
            JSON
            --------------------------------------------------- */

            const result =
                await response.json();


            // console.log(
            //     'WISHLIST PHP RESPONSE:',
            //     result
            // );


            /* ---------------------------------------------------
            PHP ERROR
            --------------------------------------------------- */

            if (
                !result ||
                result.status !== true
            ) {

                // console.error(
                //     'WISHLIST PHP ERROR:',
                //     result?.message
                // );


                container.innerHTML =
                    getWishlistErrorHTML();

                return;
            }


            /* ---------------------------------------------------
            GET PACKAGES
            --------------------------------------------------- */

            const packages =
                Array.isArray(result.data)
                    ? result.data
                    : [];


            /* ---------------------------------------------------
            RENDER
            --------------------------------------------------- */

            renderWishlistItems(
                packages
            );

        } catch (error) {

            // console.error(
            //     'WISHLIST FETCH ERROR:',
            //     error
            // );


            container.innerHTML =
                getWishlistErrorHTML();
        }
    }


    /* =========================================================
    FORMAT PRICE
    ========================================================= */

    function formatWishlistPrice(price) {

        const amount =
            Number(price || 0);


        return amount.toLocaleString(
            'en-IN',
            {
                minimumFractionDigits: 0,
                maximumFractionDigits: 2
            }
        );
    }


    /* =========================================================
    IMAGE PATH
    ========================================================= */

    function getWishlistImagePath(image) {

        if (!image) {
            return '';
        }

        image = String(image).trim();

        /* -------------------------------------------------------
        FULL URL
        ------------------------------------------------------- */

        if (
            image.startsWith('http://') ||
            image.startsWith('https://')
        ) {
            return image;
        }


        /* -------------------------------------------------------
        REMOVE LEADING SLASHES
        ------------------------------------------------------- */

        image = image.replace(/^\/+/, '');


        /* -------------------------------------------------------
        LOCAL XAMPP
        ------------------------------------------------------- */

        const hostname = window.location.hostname;

        if (
            hostname === 'localhost' ||
            hostname === '127.0.0.1'
        ) {
            return '/ca.uniqbizz.com/' + image;
        }


        /* -------------------------------------------------------
        DEV / LIVE
        ------------------------------------------------------- */

        return '/' + image;
    }


    /* =========================================================
    ESCAPE HTML
    ========================================================= */

    function escapeWishlistHTML(value) {

        return String(value ?? '')
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;')
            .replace(/'/g, '&#039;');
    }


    /* =========================================================
    RENDER WISHLIST ITEMS
    ========================================================= */

    function renderWishlistItems(packages) {

        const container =
            document.getElementById(
                'wishlistItems'
            );


        /* -------------------------------------------------------
        CHECK CONTAINER
        ------------------------------------------------------- */

        // if (!container) {

        //     console.error(
        //         'WISHLIST: Container missing during render'
        //     );

        //     return;
        // }


        /* -------------------------------------------------------
        REMOVE DUPLICATES
        ------------------------------------------------------- */

        const uniquePackages = [];

        const seen =
            new Set();


        packages.forEach(packageItem => {

            if (
                !packageItem ||
                packageItem.id === undefined ||
                packageItem.id === null
            ) {
                return;
            }


            const id =
                String(
                    packageItem.id
                ).trim();


            if (!id) {
                return;
            }


            if (!seen.has(id)) {

                seen.add(id);

                uniquePackages.push(
                    packageItem
                );
            }

        });


        /* -------------------------------------------------------
        EMPTY
        ------------------------------------------------------- */

        if (uniquePackages.length === 0) {

            container.innerHTML =
                getEmptyWishlistHTML();

            return;
        }


        /* -------------------------------------------------------
        BUILD HTML
        ------------------------------------------------------- */

        let html = '';


        uniquePackages.forEach(packageItem => {

            /* ---------------------------------------------------
            PACKAGE ID
            --------------------------------------------------- */

            const packageId =
                String(
                    packageItem.id
                ).trim();


            /* ---------------------------------------------------
            PACKAGE NAME
            --------------------------------------------------- */

            const packageName =
                packageItem.package_name ||
                'Package';


            /* ---------------------------------------------------
            PRICE
            --------------------------------------------------- */

            const displayPrice =
                formatWishlistPrice(
                    packageItem.net_price_adult
                );


            /* ---------------------------------------------------
            IMAGE
            --------------------------------------------------- */

            const image =
                getWishlistImagePath(
                    packageItem.cover_image
                );


            /* ---------------------------------------------------
            ESCAPED VALUES
            --------------------------------------------------- */

            const safePackageId =
                escapeWishlistHTML(
                    packageId
                );


            const safePackageName =
                escapeWishlistHTML(
                    packageName
                );

            /* ---------------------------------------------------
            CHECK IF ALREADY SAVED IN DATABASE
            --------------------------------------------------- */

            const isAlreadySaved =
                packageItem.is_saved === true ||
                packageItem.is_saved === 1 ||
                String(packageItem.is_saved) === '1';


            const saveWishlistButton =
                isWishlistUserLoggedIn
                    ? isAlreadySaved
                        ? `
                            <button
                                type="button"
                                class="btn btn-sm text-primary saveWishlist"
                                data-package-id="${safePackageId}"
                                title="Saved"
                                disabled
                            >
                                <i class="ri-checkbox-circle-line"></i>
                            </button>
                        `
                        : `
                            <button
                                type="button"
                                class="btn btn-sm text-success saveWishlist"
                                data-package-id="${safePackageId}"
                                title="Save to account"
                            >
                                <i class="ri-save-line"></i>
                            </button>
                        `
                    : '';
            /* ---------------------------------------------------
            HTML
            --------------------------------------------------- */

            html += `

                <div class="wishlist-item
                            border-bottom
                            pb-3
                            mb-3"
                     data-package-id="${safePackageId}">


                    <div class="d-flex
                                gap-3
                                align-items-center
                                wishlist-package-link"
                         data-package-id="${safePackageId}"
                         style="cursor:pointer;">


                        <!-- IMAGE -->

                        <img
                            src="${image}"
                            alt="${safePackageName}"
                            class="rounded"
                            style="
                                width:90px;
                                height:70px;
                                object-fit:cover;
                                flex-shrink:0;
                            "
                        >


                        <!-- DETAILS -->

                        <div class="flex-grow-1">

                            <h6 class="fw-bold mb-1">
                                ${safePackageName}
                            </h6>


                            <div class="fw-bold">

                                <span>
                                    ₹
                                </span>

                                ${displayPrice}

                            </div>

                        </div>


                        <!-- SAVE + REMOVE -->

                        <div class="d-flex align-items-center gap-1">

                            ${saveWishlistButton}

                            <button
                                type="button"
                                class="btn btn-sm text-danger removeWishlist"
                                data-package-id="${safePackageId}"
                                title="Remove from wishlist"
                            >
                                <i class="ri-delete-bin-line"></i>
                            </button>

                        </div>


                    </div>

                </div>

            `;

        });


        /* -------------------------------------------------------
        INSERT
        ------------------------------------------------------- */

        container.innerHTML =
            html;


        // console.log(
        //     'WISHLIST: Rendered:',
        //     uniquePackages.length
        // );
    }


    /* =========================================================
    CLICK HANDLER
    ========================================================= */

    document.addEventListener(
    'click',
    async function (event) {


            /* =====================================================
            1. PACKAGE HEART
            ===================================================== */

            const heart =
                event.target.closest(
                    '.wishlist-icon'
                );


            if (heart) {

                event.preventDefault();
                event.stopPropagation();


                const packageId =
                    String(
                        heart.dataset.packageId || ''
                    ).trim();


                // if (!packageId) {

                //     console.error(
                //         'WISHLIST: Package ID missing'
                //     );

                //     return;
                // }


                let wishlist =
                    getWishlist();


                const index =
                    wishlist.indexOf(
                        packageId
                    );


                /* -------------------------------------------------
                ADD
                ------------------------------------------------- */

                if (index === -1) {

                    wishlist.push(
                        packageId
                    );


                    updateWishlistButton(
                        heart,
                        true
                    );


                    // console.log(
                    //     'WISHLIST: Added:',
                    //     packageId
                    // );

                }


                /* -------------------------------------------------
                REMOVE
                ------------------------------------------------- */

                else {

                    wishlist.splice(
                        index,
                        1
                    );


                    updateWishlistButton(
                        heart,
                        false
                    );


                    // console.log(
                    //     'WISHLIST: Removed:',
                    //     packageId
                    // );
                }


                saveWishlist(
                    wishlist
                );


                return;
            }


            /* =====================================================
            2. REMOVE FROM WISHLIST
            ===================================================== */

            const removeButton =
                event.target.closest(
                    '.removeWishlist'
                );


            if (removeButton) {

                event.preventDefault();
                event.stopPropagation();


                const packageId =
                    String(
                        removeButton.dataset.packageId || ''
                    ).trim();


                if (!packageId) {
                    return;
                }


                // console.log(
                //     'WISHLIST: Removing:',
                //     packageId
                // );


                /* -------------------------------------------------
                REMOVE FROM LOCAL STORAGE
                ------------------------------------------------- */

                let wishlist =
                    getWishlist();


                wishlist =
                    wishlist.filter(
                        id =>
                            String(id).trim() !== packageId
                    );


                saveWishlist(
                    wishlist
                );


                /* -------------------------------------------------
                UPDATE HEARTS
                ------------------------------------------------- */

                document
                    .querySelectorAll(
                        '.wishlist-icon'
                    )
                    .forEach(heart => {

                        const heartId =
                            String(
                                heart.dataset.packageId || ''
                            ).trim();


                        if (
                            heartId === packageId
                        ) {

                            updateWishlistButton(
                                heart,
                                false
                            );

                        }

                    });


                /* -------------------------------------------------
                RELOAD WISHLIST
                ------------------------------------------------- */

                loadWishlistItems();


                return;
            }

            /* =====================================================
            3. SAVE WISHLIST
            ===================================================== */

            const saveButton =
                event.target.closest('.saveWishlist');

            if (saveButton) {

                event.preventDefault();
                event.stopPropagation();


                /* -------------------------------------------------
                CHECK LOGIN
                ------------------------------------------------- */

                if (!isWishlistUserLoggedIn) {
                    return;
                }


                /* -------------------------------------------------
                PACKAGE ID
                ------------------------------------------------- */

                const packageId =
                    String(
                        saveButton.dataset.packageId || ''
                    ).trim();


                if (!packageId) {
                    return;
                }


                /* -------------------------------------------------
                PREVENT DOUBLE CLICK
                ------------------------------------------------- */

                if (saveButton.dataset.saving === '1') {
                    return;
                }

                saveButton.dataset.saving = '1';
                saveButton.disabled = true;


                /* -------------------------------------------------
                ICON
                ------------------------------------------------- */

                const icon =
                    saveButton.querySelector('i');


                if (icon) {

                    icon.classList.remove(
                        'ri-save-line',
                        'ri-checkbox-circle-line'
                    );

                    icon.classList.add(
                        'ri-loader-4-line'
                    );
                }


                /* -------------------------------------------------
                FORM DATA
                ------------------------------------------------- */

                const formData =
                    new FormData();

                formData.append(
                    'package_id',
                    packageId
                );


                /* -------------------------------------------------
                AJAX
                ------------------------------------------------- */

                try {

                    const response =
                        await fetch(
                            'assets/submit/save_wishlist.php',
                            {
                                method: 'POST',
                                body: formData,
                                cache: 'no-store'
                            }
                        );


                    if (!response.ok) {

                        throw new Error(
                            `HTTP ${response.status}`
                        );
                    }


                    const result =
                        await response.json();


                    /* -------------------------------------------------
                    SUCCESS
                    ------------------------------------------------- */

                    if (
                        result &&
                        result.status === true
                    ) {

                        /* ---------------------------------------------
                        CHANGE TO SAVED
                        --------------------------------------------- */

                        if (icon) {

                            icon.classList.remove(
                                'ri-loader-4-line',
                                'ri-save-line'
                            );

                            icon.classList.add(
                                'ri-checkbox-circle-line'
                            );
                        }


                        saveButton.classList.remove(
                            'text-success'
                        );

                        saveButton.classList.add(
                            'text-primary'
                        );


                        saveButton.title =
                            'Saved';


                        /*
                        Keep disabled because it is already saved.
                        */

                        saveButton.disabled = true;

                        saveButton.dataset.saving = '0';


                        return;
                    }


                    /* -------------------------------------------------
                    PHP ERROR
                    ------------------------------------------------- */

                    if (icon) {

                        icon.classList.remove(
                            'ri-loader-4-line'
                        );

                        icon.classList.add(
                            'ri-save-line'
                        );
                    }


                    saveButton.dataset.saving = '0';
                    saveButton.disabled = false;


                } catch (error) {

                    // console.error(
                    //     'WISHLIST SAVE ERROR:',
                    //     error
                    // );


                    /* ---------------------------------------------
                    RESTORE BUTTON
                    --------------------------------------------- */

                    if (icon) {

                        icon.classList.remove(
                            'ri-loader-4-line'
                        );

                        icon.classList.add(
                            'ri-save-line'
                        );
                    }


                    saveButton.dataset.saving = '0';
                    saveButton.disabled = false;
                }


                return;
            }
            /* =====================================================
            4. WISHLIST PACKAGE REDIRECT
            ===================================================== */

            const wishlistPackage =
                event.target.closest(
                    '.wishlist-package-link'
                );


            if (wishlistPackage) {

                event.preventDefault();
                event.stopPropagation();


                const packageId =
                    String(
                        wishlistPackage.dataset.packageId || ''
                    ).trim();


                if (!packageId) {

                    // console.error(
                    //     'WISHLIST: Package ID missing for redirect'
                    // );

                    return;
                }


                // console.log(
                //     'WISHLIST: Opening package:',
                //     packageId
                // );


                window.location.href =
                    `tour-details.php?pacId=${encodeURIComponent(packageId)}`;


                return;
            }


            /* =====================================================
            5. WISHLIST HEADER BUTTON
            ===================================================== */

            const wishlistButton =
                event.target.closest(
                    '[data-bs-target="#wishlistOffcanvas"]'
                );


            if (wishlistButton) {

                // console.log(
                //     'WISHLIST: Header button clicked'
                // );


                /*
                Do NOT use preventDefault()
                or stopPropagation() here.

                Bootstrap needs the click event
                to open the offcanvas.
                */

                loadWishlistItems();


                return;
            }

        }
    );


    /* =========================================================
    DOM READY
    ========================================================= */

    document.addEventListener(
        'DOMContentLoaded',
        async function () {

            // console.log(
            //     'WISHLIST: Initializing'
            // );


            /* ---------------------------------------------------
            COUNT
            --------------------------------------------------- */

            updateWishlistCount();


            /* ---------------------------------------------------
            HEARTS
            --------------------------------------------------- */

            loadWishlistHeartState();

            
            /*
            |--------------------------------------------------------------------------
            | SYNC DATABASE WISHLIST
            |--------------------------------------------------------------------------
            */

            if (isWishlistUserLoggedIn) {

                await syncWishlistWithDB();

                updateWishlistCount();

                loadWishlistHeartState();
            }

        }
    );


    /* =========================================================
    AJAX / DYNAMIC PACKAGE SUPPORT
    ========================================================= */

    window.refreshWishlistUI = function () {

        updateWishlistCount();

        loadWishlistHeartState();

    };

</script>