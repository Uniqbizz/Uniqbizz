<?php
session_start();

if (!isset($_SESSION['username'])) {
    echo '<script>location.href = "../login.php";</script>';
}
$date = date('Y'); 
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Enquiries</title>
        <!-- App favicon -->
        <link rel="shortcut icon" href="../assets/images/fav.png">
        <!-- custom css file -->
        <!-- <link href="../assets/css/styles.css" rel="stylesheet" type="text/css" /> -->
        <!-- Bootstrap Css -->
        <link href="../assets/css/bootstrap.min.css" id="bootstrap-style" rel="stylesheet" type="text/css" />
        <!-- Icons Css -->
        <link href="../assets/css/icons.min.css" rel="stylesheet" type="text/css" />
        <!-- App Css-->
        <link href="../assets/css/app.min.css" id="app-style" rel="stylesheet" type="text/css" />
        <!-- Css-->
        <link href="../assets/css/loadingScreen.css" id="app-style" rel="stylesheet" type="text/css" />
        <!-- Prepare Quotation Css-->
        <link href="../assets/css/prepareQuotation.css" id="app-style" rel="stylesheet" type="text/css" />
        <!-- App js -->
        <!-- <script src="assets/js/plugin.js"></script> -->
        <!-- DataTables -->
        <link href="../assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />

        <!-- Responsive datatable examples -->
        <link href="../assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css" />
        <!-- Font Awesome Icons -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <!-- Date Range Picker CSS Start -->
        <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
        <!-- Date Range Picker CSS End -->
    </head>
    <body data-sidebar="dark">
        <div class="layout-wrapper">
            <?php
                // top header logo, hamberger menu, fullscreen icon, profile
                include_once '../header.php';

                // sidebar navigation menu 
                include_once '../sidebar.php';

                $today = date('Y-m-d'); // Get today's date as a string

                $mindate= "01-01-2022";
                $maxdate=$today;
            ?>
            <div class="main-content">
                <div class="page-content">
                    <div class="container-fluid">
                        <!-- start page title -->
                        <div class="row">
                            <div class="col-9">
                                <div class="page-title-box pb-2">
                                    <h4 class="mb-sm-0 font-size-18">Prepare Quotation</h4>
                                    <p class="fontSize12">Review customer request, customize the package and prepare the best quotation.</p>
                                </div>
                            </div>
                            <div class="col-3 d-flex justify-content-end gap-3">
                                <div class="shareLinksBtn">
                                    <i class="fa-regular fa-envelope"></i>
                                </div>
                                <div class="shareLinksBtn">
                                    <i class="fa-brands fa-whatsapp"></i>
                                </div>
                                <div class="shareLinksBtn">
                                    <i class="fa-solid fa-print"></i>
                                </div>
                                <div class="shareLinksBtn2">
                                    <i class="fa-solid fa-ellipsis"></i>
                                </div>
                            </div>
                        </div>
                        <!-- end page title -->
                        <!-- Card Section 1 Start -->
                        <div class="row rowAlignment">
                            <div class="col-12">
                                <div class="card cardShadow">
                                    <div class="d-flex tabDisplayBlock">
                                        <div class="p-2 imageWrapper">
                                            <img src="../assets/images/andaman_nicobar.jpg" alt="" class="prepareQuotationImg">
                                        </div>
                                        <div class="p-3 widthStretch">
                                            <div class="packageIDBtn">
                                                PKG-AN001
                                            </div>
                                            <p class="fw-bolder text-black mb-1 fs-4" id="">Andaman and Nicobar Island</p>
                                            <p class="fw-bold text-black mb-1 fs-5" id="">The Jewel of the Indian Ocean</p>
                                            <div class="d-flex gap-4 redIcons laptopDisplay">
                                                <p class="fontSize10 mb-3">
                                                    <i class="fa-solid fa-location-dot me-2"></i>
                                                    Andaman and Nicobar Island
                                                </p>
                                                <p class="fontSize10 mb-3">
                                                    <i class="fa-regular fa-calendar me-2"></i>
                                                    4 Nights / 5 Days
                                                </p>
                                                <p class="fontSize10 mb-3">
                                                    <i class="fa-solid fa-utensils me-2"></i>
                                                    Meals: Breakfast
                                                </p>
                                            </div>
                                            <p class="fontSize12 mb-3">
                                                The Andaman and Nicobar Island are a tropical haven in the Bay of Bengal, known for its immaculate beaches, crystal-clear turquoise waters, and abundant marine life.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Card Section 1 End -->
                        <!-- Card Section 2 Start -->
                        <div class="row">
                            <div class="col-xl-8">
                                <!-- Card Section 2 subsection 1 Start -->
                                <div class="card p-3">
                                    <h5 class="fw-bold text-black">
                                        <i class="fa-solid fa-clipboard-list fa-xl me-3"></i>
                                        Enquiry Information
                                    </h5>
                                    <div class="row">
                                        <div class="col-xl-6 d-flex gap-2">
                                            <p class="fs-6 mb-0">Enquiry ID:</p>
                                            <p class="fs-6 mb-0 fw-bold">ENQ-20260908-001</p>
                                        </div>
                                        <div class="col-xl-6 d-flex gap-2">
                                            <p class="fs-6 mb-0">Received On:</p>
                                            <p class="fs-6 mb-0 fw-bold">08 Sep 2026, 10:35 AM</p>
                                        </div>
                                    </div>
                                </div>
                                <!-- Card Section 2 subsection 1 End -->
                            </div>
                            <div class="col-xl-4"></div>
                        </div>
                        <!-- Card Section 2 End -->

                    </div>
                </div>
                <?php include_once "../footer.php" ?>
            </div>
        </div>
        <!-- END layout-wrapper -->
        <!--start back-to-top-->
        <button onclick="topFunction()" class="scrollToTop scroll-btn show btn" id="back-to-top">
            <i class="mdi mdi-arrow-up"></i>
        </button>
        <!--end back-to-top-->
        <!-- JAVASCRIPT -->
        <script src="../assets/libs/jquery/jquery.min.js"></script>
        <script src="../assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
        <script src="../assets/libs/metismenu/metisMenu.min.js"></script>
        <script src="../assets/libs/simplebar/simplebar.min.js"></script>
        <script src="../assets/libs/node-waves/waves.min.js"></script>
        <!-- Required datatable js -->
        <script src="../assets/libs/datatables.net/js/jquery.dataTables.min.js"></script>
        <script src="../assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>

        
        <!-- Responsive examples -->
        <script src="../assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
        <script src="../assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js"></script>
        <!-- Calendar init -->
        <script src="../assets/libs/fullcalendar/index.global.min.js"></script>

        <!-- Date Range Picker Script Start -->
        <!-- <script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script> -->
        <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
        <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
        <!-- Date Range Picker Script End -->

        <!-- App js -->
        <script src="../assets/js/app.js"></script>
        <script>
            var mybutton = document.getElementById("back-to-top");

            function scrollFunction() {
                100 < document.body.scrollTop || 100 < document.documentElement.scrollTop ? mybutton.style.display = "block" : mybutton.style.display = "none"
            }

            function topFunction() {
                document.body.scrollTop = 0,
                    document.documentElement.scrollTop = 0
            }
            mybutton && (window.onscroll = function() {
                scrollFunction()
            });
        </script>
    </body>
</html>