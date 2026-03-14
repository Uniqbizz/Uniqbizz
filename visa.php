<?php 
    session_start();
?>
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
        <title>Bizzmirth Holidays Pvt Ltd</title>
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
        <!-- Animated Cursor GSAP -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.13.0/gsap.min.js"></script>
        <style>
            .visaPackage {
                background: var(--secondary-border);
            }
            .visaPackage .visaPackageCard .visaPackageImg{
                overflow: hidden;
                border-radius: 50%;
            }
            .visaPackage .visaPackageCard .visaPackageImg img {
                width: 270px;
                height: 270px; 
                border-radius: 50%;
            }
            .visaPackageCard {
                position: relative;
            }
            .visaPackageContent {
                position: absolute;
                bottom: -5px;
                left: -2px;
                width: 265px;
            }
            /* image transition */
            .visaPackage .visaPackageCard .visaPackageImg img{
                width: 100%;
                transition: all 0.5s ease-in;
            }

            /* hover image effect */
            .visaPackage .visaPackageCard:hover .visaPackageImg img{
                transform: scale(1.08);
            }

            /* content transition */
            .visaPackage .visaPackageCard .visaPackageContent{
                transition: all 0.5s ease-out;
            }

            /* hover background */
            .visaPackage .visaPackageCard:hover .visaPackageContent{
                background-color: #1781fe;
                color: #fff;
            }

            /* link color on hover */
            .visaPackage .visaPackageCard:hover .visaPackageContent a{
                color: #fff;
            }

            /* processing text color */
            .visaPackage .visaPackageCard:hover .visaPackageContent .text-tertiary{
                color: #fff !important;
            }
            /* Animated Cursor Start */
            * {
                box-sizing: border-box;
                padding: 0;
                margin: 0;
            }

            .cursor {
                width: 100%;
                height: 100%;
                background: transparent;
            }

            .cursor-example {
                position: fixed;
                top: 0;
                left: 0;
                width: 25px;
                height: 25px;
                border-radius: 100%;
                background-color: #73b0f6;
                opacity: 0.3;
                z-index: 1000;
            }
            /* End Animated Cursor */
            @media (max-width: 1199px) {
                .visaPackageContent {
                    position: absolute;
                    bottom: -5px;
                    left: -2px;
                    width: 275px;
                }
            }
            @media (max-width: 767px) {
                .visaPackage .visaPackageCard .visaPackageImg img {
                    width: 230px;
                    height: 230px; 
                    border-radius: 50%;
                }
                .visaPackageContent {
                    position: absolute;
                    bottom: -5px;
                    left: -6px;
                    width: 245px;
                }
            }
            @media (max-width: 575px) {
                .visaPackage .visaPackageCard .visaPackageImg img {
                    width: 270px;
                    height: 270px; 
                    border-radius: 50%;
                }
                .visaPackageContent {
                    position: absolute;
                    bottom: -5px;
                    left: -35px;
                    width: 340px;
                }
            }
        </style>
    </head>
    <body>
        <!-- /* Animated Cursor Start */ -->
        <div class="cursor"></div>

        <div class="cursor-example"></div>
        <!-- /* End of Animated Cursor */ -->
        <?php include_once "header.php" ?>
        <main>
            
            <!-- Breadcrumbs S t a r t -->
            <section class="breadcrumbs-area breadcrumb-bg">
                <div class="container">
                    <h1 class="title wow fadeInUp" data-wow-delay="0.0s">Visa</h1>
                    <div class="breadcrumb-text">
                        <nav aria-label="breadcrumb" class="breadcrumb-nav wow fadeInUp" data-wow-delay="0.1s">
                            <ul class="breadcrumb listing">
                                <li class="breadcrumb-item single-list"><a href="index.php" class="single">Home</a></li>
                                <li class="breadcrumb-item single-list" aria-current="page">
                                    <a href="javascript:void(0)" class="single active">Visa</a></li>
                            </ul>
                        </nav>
                    </div>
                </div>

            </section>
            <!--/ End-of Breadcrumbs-->
            <!-- Visa Card Section Start -->
            <div class="visaPackage pt-100 pb-100">
                <div class="container">
                    <div class="row gy-5" id="visaCards">
                    </div>
                </div>
            </div>
            <!-- End of Visa Card Section -->
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
        <!-- Visa Package Card Start Js  -->
        <script>
            const visaPackages = [
                {
                    country: "Australia",
                    image: "assets/images/visa/visa-package-img1.jpg",
                    processing: "(15 - 30) Days",
                    link: "#"
                },
                {
                    country: "Canada",
                    image: "assets/images/visa/visa-package-img2.jpg",
                    processing: "(10 - 20) Days",
                    link: "#"
                },
                {
                    country: "United Kingdom",
                    image: "assets/images/visa/visa-package-img3.jpg",
                    processing: "(01 - 02) Months",
                    link: "#"
                },
                {
                    country: "United State",
                    image: "assets/images/visa/visa-package-img4.jpg",
                    processing: "(01 - 03) Months",
                    link: "#"
                },
                {
                    country: "France",
                    image: "assets/images/visa/visa-package-img5.jpg",
                    processing: "(01 - 02) Months",
                    link: "#"
                },
                {
                    country: "Germany",
                    image: "assets/images/visa/visa-package-img6.jpg",
                    processing: "(15 - 30) Days",
                    link: "#"
                },
                {
                    country: "Qatar",
                    image: "assets/images/visa/visa-package-img7.jpg",
                    processing: "(15 - 25) Days",
                    link: "#"
                },
                {
                    country: "Switzerland",
                    image: "assets/images/visa/visa-package-img8.jpg",
                    processing: "(10 - 20) Days",
                    link: "#"
                }
            ];

            const visaContainer = document.getElementById("visaCards");

            visaPackages.forEach((visa, index) => {

                const card = document.createElement("div");
                card.className = "col-xl-3 col-lg-4 col-md-6 col-sm-6 col-12 wow animate fadeInDown d-flex justify-content-center";
                card.setAttribute("data-wow-delay", `${index * 200}ms`);
                card.setAttribute("data-wow-duration", "1500ms");

                card.innerHTML = `
                    <div class="visaPackageCard">
                        <div class="visaPackageImg">
                            <img src="${visa.image}" alt="${visa.country}">
                        </div>

                        <div class="visaPackageContent card pt-18 pb-18 border-0 rounded-4">
                            <h5 class="text-center fw-bold">
                                <a href="${visa.link}">${visa.country}</a>
                            </h5>

                            <span class="text-14 text-center">
                                Processing Time -
                                <strong class="text-tertiary">${visa.processing}</strong>
                            </span>
                        </div>
                    </div>
                `;

                visaContainer.appendChild(card);
            });
        </script>
        <!-- End of Visa Package Card Js  -->
        <script>
            let posX = 0,
            posY = 0;

            let mouseX = 0,
            mouseY = 0;

            gsap.to(".cursor-example", {
                duration: 0.018,
                repeat: -1,
                onRepeat: function () {
                    posX += (mouseX - posX) / 8;
                    posY += (mouseY - posY) / 8;

                    gsap.set(".cursor-example", {
                    css: {
                        left: posX - 1,
                        top: posY - 2
                    }
                });
            }
            });

            document.addEventListener("mousemove", (e) => {
                mouseX = e.clientX;
                mouseY = e.clientY;
            });
        </script>
    </body>
</html>