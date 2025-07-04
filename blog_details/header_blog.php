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
                                    <div class="logo">
                                        <a href="../index.php"><img src="../assets/images/bizz_logo.png" height="55px" width="80px" ></a>
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
                                                    <a href="../index.php" class="single">Home</a>
                                                </li>
                                                <li class="single-list">
                                                    <a href="../about.php" class="single">About</a>
                                                </li>
                                                <li class="single-list">
                                                    <a href="../blogs.php" class="single">Blogs</a>
                                                </li>
                                                <li class="single-list">
                                                    <a href="../tour-list.php" class="single">Tour Package</a>
                                                </li>
                                                <li class="single-list">
                                                    <a href="../contact.php" class="single">Contact</a>
                                                </li>
                                            </ul>
                                            <div class="header-right">
                                                <div class="sign-btn">
                                                    <?php 
                                                        if(isset($_SESSION['username2'])){
                                                            echo '<a href="dashboard/" class="btn-secondary-sm">Dashboard</a>
                                                            <a href="../login.php" class="btn-secondary-sm my2logout">Logout</a>';
                                                        }else{
                                                            echo'<a href="../login.php" class="btn-secondary-sm">Log In</a>';
                                                        }
                                                    ?>
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
                            <!-- Mobile Menu -->
                            <div class="div">
                                <div class="mobile_menu d-block d-lg-none"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>