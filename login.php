<?php  
    include_once "connect.php";
    $date = date('Y');
?>
<!DOCTYPE html>
<html lang="zxx" dir="lrt">

<!-- Mirrored from travelloo.vercel.app/template/login.html by HTTrack Website Copier/3.x [XR&CO'2014], Fri, 12 Jul 2024 06:52:53 GMT -->
<!-- Added by HTTrack --><meta http-equiv="content-type" content="text/html;charset=utf-8" /><!-- /Added by HTTrack -->
<head>
    <script>
        const setTheme = (theme) => {
            theme ??= localStorage.theme || "light";
            document.documentElement.dataset.theme = theme;
            localStorage.theme = theme;
        };
        setTheme();
    </script>
    <meta logo="assets/images/logo/logo.png">
    <meta white-logo="assets/images/logo/logo-white.png">
    
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="description" content="Mirthtrip Bizzmirth">
    <meta name="keywords" content="travel trip, booking,tour, tourism, blog, travel agency, tourism ">
    <meta name="author" content="inittheme">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Title -->
    <title>Uniqbizz</title>
    <link rel="icon" type="image/x-icon" sizes="20x20" href="assets/images/icon/fav.png">
    <!-- Bootstrap -->
    <link rel="stylesheet" type="text/css" href="assets/css/bootstrap-5.3.0.min.css">
    <!-- Fonts & icon -->
    <link rel="stylesheet" type="text/css" href="assets/css/remixicon.css">
    <!-- Plugin -->
    <link rel="stylesheet" type="text/css" href="assets/css/plugin.css">
    <!-- Main CSS -->
    <link rel="stylesheet" type="text/css" href="assets/css/main-style.css">
    <!-- RTL CSS::When Need RTL Uncomments File -->
    <!-- <link rel="stylesheet" type="text/css" href="assets/css/rtl.css"> -->
</head>
<body>
    <?php include_once "header.php" ?>
    <main>
        <!-- Breadcrumbs S t a r t -->
        <section class="breadcrumbs-area breadcrumb-bg">
            <div class="container">
                <h1 class="title wow fadeInUp" data-wow-delay="0.0s">Login</h1>
                <div class="breadcrumb-text">
                    <nav aria-label="breadcrumb" class="breadcrumb-nav wow fadeInUp" data-wow-delay="0.1s">
                        <ul class="breadcrumb listing">
                            <li class="breadcrumb-item single-list"><a href="index.php" class="single">Home</a></li>
                            <li class="breadcrumb-item single-list" aria-current="page">
                                <a href="javascript:void(0)" class="single active">Login</a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>

        </section>
        <!--/ End-of Breadcrumbs-->

        <!-- Login area S t a r t  -->
        <div class="login-area section-padding">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-xl-5 col-lg-6 col-md-8 col-sm-10">
                        <div class="login-card">
                            <!-- Logo -->
                            <div class="logo mb-40">
                                <a href="javascript:void(0)" class="mb-30 d-block">
                                    <img src="assets/images/bizz_logo.png" height="55px" width="80px" >
                                </a>
                            </div>
                            <!-- Form -->
                            <form action="#" method="POST">

                                <div class="position-relative contact-form mb-24">
                                    <label class="contact-label">Login As </label>
                                    <select id="user_type" class="contact-input">
                                        <option value=""> -- Select Login As -- </option>;
                                        <?php 
                                            $sql = "SELECT * FROM `user_type` WHERE status = '1' AND id IN (10, 11, 3, 16, 15, 18, 19, 24, 25, 26) ";
                                            $stmt = $conn -> prepare($sql);
                                            $stmt -> execute();
                                            $stmt -> setFetchMode(PDO::FETCH_ASSOC);
                                            if($stmt -> rowCount()>0){
                                                foreach(($stmt->fetchAll()) as $key => $value){
                                                    echo'<option value="'.$value['id'].'">'.$value['name'].'</option>';
                                                }
                                            }else{
                                                echo'<option value=""> No data Avaiable </option>;';
                                            }
                                        ?>
                                    </select>
                                </div>

                                <div class="position-relative contact-form mb-24">
                                    <label class="contact-label">Email </label>
                                    <input class="form-control contact-input" type="text"
                                        id="username" placeholder="Enter username" value="<?php if(isset($_COOKIE['user2'])){echo $_COOKIE['user2'];}?>">
                                </div>

                                <div class="contact-form mb-24">
                                    <div class="position-relative ">
                                        <div class="d-flex justify-content-between aligin-items-center">
                                            <label class="contact-label">Password</label>
                                        </div>
                                        <input type="password" class="form-control contact-input password-input"
                                            id="password" value="<?php if(isset($_COOKIE['pass'])){echo $_COOKIE['pass'];}?>" autocomplete="on" placeholder="Enter Password">
                                        <i class="toggle-password ri-eye-line"></i>
                                    </div>
                                </div>

                                <div class="contact-form mb-24">
                                    <input class="mx-2" type="checkbox" id="remember_me">
                                    <label class="contact-label">Remember Me </label>
                                </div>

                                <div class="contact-form mb-24" id="terms_view_box" style="display: none;">
                                    <input class="mx-2" type="checkbox" value="" name="terms_condtion" id="terms_condtion">
                                    <label class="contact-label" for="terms_condtion">I agree to the terms and condition</label>
                                    <a href="javascript:void(0)" onclick="document.getElementById('light').style.display='block';document.getElementById('fade').style.display='block'">View Terms and Conditions</a>
                                </div>

                                <a href="javascript:void(0)" id="login" class="btn-primary-fill justify-content-center w-100">
                                    <span class="d-flex justify-content-center gap-6">
                                        <span>Login</span>
                                    </span>
                                </a>
                            </form>

                            <!-- <div class="login-footer">
                                <div class="create-account">
                                    <p>
                                        Don’t have an account?
                                        <a href="register.html">
                                            <span class="text-primary">Register</span>
                                        </a>
                                    </p>
                                </div>
                                <a href="javascript:void(0)"
                                    class="login-btn d-flex align-items-center justify-content-center gap-10">
                                    <img src="assets/images/icon/google-icon.png" alt="img" class="m-0">
                                    <span> login with Google</span>
                                </a>
                            </div> -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--/ End-of Login -->
    </main>

    <!-- Footer S t a r t -->
    <?php include_once "footer.php" ?>
    <!--/ End-of Footer -->

    <!-- Scroll Up  -->
    <div class="progressParent" id="back-top">
        <svg class="backCircle svg-inner" width="100%" height="100%" viewBox="-1 -1 102 102">
            <path d="M50,1 a49,49 0 0,1 0,98 a49,49 0 0,1 0,-98" />
        </svg>
    </div>
    <!-- Add an search-overlay element -->
    <div class="search-overlay"></div>
    <!-- jquery-->
    <script src="assets/js/jquery-3.7.0.min.js"></script>
    <script src="assets/js/popper.min.js"></script>
    <script src="assets/js/bootstrap-5.3.0.min.js"></script>
    <!-- Plugin -->
    <script src="assets/js/plugin.js"></script>
    <!-- Main js-->
    <script src="assets/js/main.js"></script>
    <script src="login_data/login.js"></script>
    <script type="text/javascript" src="logout/logout.js"></script>
</body>
</html>