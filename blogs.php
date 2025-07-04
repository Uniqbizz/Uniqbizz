<!DOCTYPE html>
<html lang="zxx" dir="lrt">

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
    <meta name="description" content="Travello - Multipurpose travel and tour booking.These template is suitable for  travel agency , tour, travel website , tour operator , tourism , booking  trip or adventure website. ">
    <meta name="keywords" content="travel, trip booking,tour, hotel, tour guide, tourism, blog, flight, travel agency, tourism agency, accommodation, tour website">
    <meta name="author" content="inittheme">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta property="og:type" content="website">
    <meta property="og:title" content="Multipurpose travel and tour booking">
    <meta property="og:site_name" content="Travello">
    <meta property="og:url" content="https://inittheme.com">
    <meta property="og:image" content="https://inittheme.com/images/selfie.jpg">
    <meta property="og:description" content="Multipurpose travel and tour booking, multipurpose template">
    <meta name="twitter:title" content="Multipurpose travel and tour booking">
    <meta name="twitter:description" content="Multipurpose travel and tour booking, multipurpose template">
    <meta name="twitter:image" content="https://twitter.com/inittheme/photo">
    <meta name="twitter:card" content="summary">
    <!-- Google site verification -->
    <meta name="google-site-verification" content="...">
    <meta name="facebook-domain-verification" content="...">
    <meta name="csrf-token" content="...">
    <meta name="currency" content="$">
    <!-- Title -->
    <title>Multipurpose travel and tour booking </title>
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
                <h1 class="title wow fadeInUp" data-wow-delay="0.0s">Blogs</h1>
                <div class="breadcrumb-text">
                    <nav aria-label="breadcrumb" class="breadcrumb-nav wow fadeInUp" data-wow-delay="0.1s">
                        <ul class="breadcrumb listing">
                            <li class="breadcrumb-item single-list"><a href="index.php" class="single">Home</a></li>
                            <li class="breadcrumb-item single-list" aria-current="page"><a href="javascript:void(0)"
                                    class="single active">Blogs</a></li>
                        </ul>
                    </nav>
                </div>
            </div>
        </section>
        <!--/ End-of Breadcrumbs-->

        <!-- Destination area S t a r t -->
        <section class="destination-section bottom-padding1">
            <div class="destination-area">
                <div class="container">
                    <div class="row g-4">
                        <div class="col-lg-4 col-sm-6">
                            <a href="blog_details/blog-details-kerala.php" class="destination-banner h-calc">
                                <img src="assets/images/destination/kerala1.jpg" alt="">
                                <div class="destination-content">
                                    <!-- <div class="ratting-badge">
                                        <i class="ri-star-s-fill"></i>
                                        <span>4.5</span>
                                    </div> -->
                                    <div class="destination-info">
                                        <div class="destination-name">
                                            <p class="pera">Kerala</p>
                                            <!-- <div class="location">
                                                <i class="ri-map-pin-line"></i>
                                                <p class="name">Malaga View</p>
                                            </div> -->
                                        </div>
                                        <div class="button-section">
                                            <div class="arrow-btn"><i class="ri-arrow-right-line"></i></div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-lg-4 col-sm-6">
                            <a href="blog_details/blog-details-goa.php" class="destination-banner h-calc">
                                <img src="assets/images/destination/goa5.jpg" alt="travello">
                                <div class="destination-content">
                                    <!-- <div class="ratting-badge">
                                        <i class="ri-star-s-fill"></i>
                                        <span>4.5</span>
                                    </div> -->
                                    <div class="destination-info">
                                        <div class="destination-name">
                                            <p class="pera">Goa</p>
                                            <!-- <div class="location">
                                                <i class="ri-map-pin-line"></i>
                                                <p class="name">Malaga View</p>
                                            </div> -->
                                        </div>
                                        <div class="button-section">
                                            <div class="arrow-btn"><i class="ri-arrow-right-line"></i></div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                       
                    </div>
                </div>
            </div>
        </section>
        <!--/ End-of Destination -->
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
    <script type="text/javascript" src="logout/logout.js"></script>
</body>
</html>