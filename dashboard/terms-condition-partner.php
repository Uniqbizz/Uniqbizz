<?php
    include_once 'dashboard_user_details.php';
?>
<!doctype html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg" data-sidebar-image="none" data-preloader="disable">
    <head>

        <meta charset="utf-8" />
        <title>Terms & condition</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!-- App favicon -->
        <link rel="shortcut icon" href="assets/images/fav.png">

        <!-- jsvectormap css -->
        <link href="assets/libs/jsvectormap/css/jsvectormap.min.css" rel="stylesheet" type="text/css" />

        <!--Swiper slider css-->
        <link href="assets/libs/swiper/swiper-bundle.min.css" rel="stylesheet" type="text/css" />

        <!-- Layout config Js -->
        <script src="assets/js/layout.js"></script>
        <!-- Bootstrap Css -->
        <link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <!-- Icons Css -->
        <link href="assets/css/icons.min.css" rel="stylesheet" type="text/css" />
        <!-- App Css-->
        <link href="assets/css/app.min.css" rel="stylesheet" type="text/css" />
        <!-- custom Css-->
        <link href="assets/css/custom.min.css" rel="stylesheet" type="text/css" />
        <!-- custom Css developer-->
        <link rel="stylesheet" href="assets/css/custom.css" />
        <link rel="stylesheet" href="assets/fontawesome/css/all.min.css" />
    </head>

    <body>
 
        <!-- Begin page -->
        <div id="layout-wrapper">

            <?php include_once 'header.php'; ?>

            <!-- removeNotificationModal -->
            <div id="removeNotificationModal" class="modal fade zoomIn" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="NotificationModalbtn-close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mt-2 text-center">
                                <lord-icon src="../../../../cdn.lordicon.com/gsqxdxog.json" trigger="loop" colors="primary:#f7b84b,secondary:#f06548" style="width:100px;height:100px"></lord-icon>
                                <div class="mt-4 pt-2 fs-15 mx-4 mx-sm-5">
                                    <h4>Are you sure ?</h4>
                                    <p class="text-muted mx-4 mb-0">Are you sure you want to remove this Notification ?</p>
                                </div>
                            </div>
                            <div class="d-flex gap-2 justify-content-center mt-4 mb-2">
                                <button type="button" class="btn w-sm btn-light" data-bs-dismiss="modal">Close</button>
                                <button type="button" class="btn w-sm btn-danger" id="delete-notification">Yes, Delete It!</button>
                            </div>
                        </div>

                    </div><!-- /.modal-content -->
                </div><!-- /.modal-dialog -->
            </div><!-- /.modal -->
            <!-- ========== App Menu ========== -->
           
            <?php include_once 'sidebar.php'; ?>

            <!-- ============================================================== -->
            <!-- Start right Content here -->
            <!-- ============================================================== -->
            <div class="main-content">

                <div class="page-content">
                    <div class="container-fluid">
                        <!-- start page title -->
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <h2 class="p-4 text-white fw-bolder m-2 text-center" style="background-color: #0036A2;">Terms & Conditions</h2>
                                <section>
                                    <div class="container p-5 pt-1">
                                        <h3 class="py-3">Business Partner Definition and Duties:</h3>
                                        <ul style="list-style-type:disc;">
                                            <li>Business Partner is a self-employed individual and is not hired directly by Uniqbizz.</li>
                                            <li>Business Partner is appointed as part of the distribution channel on different lines and in capacity for lead generation and conversions for pre-defined benefits through his/her channel developed.</li>
                                            <li>Business Partner undertakes to recruit and develop a team of Business Consultants as per requirements laid down by company from time to time.</li>
                                            <li>Business Partner undertakes to advertise the travel services of the company at his/her expense.</li>
                                            <li>Business Partner is not to use the company advertisement and promotional materials to advertise other travel companies.</li>
                                            <li>Business Partner is to provide the company all the necessary documents concerning their association with Uniqbizz.</li>
                                            <li>Any disputes arising between Business Partner & Business Consultancy are to be settled between Business Partner & Business Consultancy and Uniqbizz is not responsible for the same.</li>
                                            <li>The Business Partner undertakes to carry out business for Uniqbizz and its various divisions/associates as mentioned and will also cover any new division / associates including online portals, channels, brands and sources in India and overseas, as and when created/acquired during the period of the contract.</li>
                                            <li>Uniqbizz may terminate this Agreement immediately upon written notice to Business Partner.  Such suspension or termination of this Agreement shall not subject Uniqbizz to any liability, whether in contract or tort or otherwise and Uniqbizz's rights to indemnification shall survive such suspension or termination of this Agreement.</li>
                                            <li>Business Partner undertakes to attend trainings/workshops/meetings as and when required by Uniqbizz.</li>
                                            <li>In the event a Business Partner is unable to complete pre-defined recruitment of Business Consultants within 45 days, the Business Partner stands a chance to face deactivation.</li>
                                            <li>Business Partner payouts will be in monthly cycles and Quarterly bonuses based on the number of active Business Consultants.</li>
                                            <li>Income earned by Business Partner is subject to TDS and other applicable taxes governed at the time.</li>
                                        </ul>

                                        <h3 class="py-3">Terms and conditions</h3>
                                        <ul style="list-style-type: disc;">
                                            <li>Income shown is illustrative and Uniqbizz reserves the right to change, modify or withdraw any or all benefits and incentives as per company requirements from time to time.</li>
                                            <li>Uniqbizz acts as a Facilitator by connecting customers with the vendors. Uniqbizz does not own any inventory and Any issues or concerns faced by the customer at the time of availing of any services shall not be the sole responsibility of Uniqbizz. Uniqbizz will have no liability with respect to the Acts, Omissions, Errors, Representations, Warranties, Breaches or negligence on any part of the Business Partner & Business Consultancy or any third party vendor partners.</li>
                                            <li>Uniqbizz takes stringent measures to ensure that we provide quality vendors at all locations. However, it is not in our direct control to ensure product and service quality at our vendors, and Uniqbizz cannot be held responsible for any  issues which are not in our direct control.</li>
                                        </ul>

                                        <h3 class="py-3">Force Majeure</h3>
                                        <ul style="list-style-type: disc;">
                                            <li>In the event of an Act of God, or of unpredictable events against which it is powerless or which are beyond its reasonable control, and includes, but is not limited to, war, riots, civil disorder, earthquake, fire, explosion, and act of terrorism, storm, flood, quarantine or other extreme adverse weather conditions, strikes, lockouts or other industrial action, the parties concerned shall be released from its obligations. </li>
                                        </ul>

                                        <h3 class="py-3">Jurisdiction:</h3>
                                        <ul style="list-style-type: disc">
                                            <li>Any dispute which cannot be settled on an amicable basis relating to the validity, interpretation, and performance of the present agreement shall be referred to arbitration of a Sole Arbitrator to be appointed in accordance with the Arbitration and Conciliation Act, 1996. The arbitration proceeding shall be held at Goa alone. The parties hereto agree that in respect of any dispute arising upon, over or in respect of any of the terms of this Agreement, only in the Courts in Goa shall have jurisdiction to try and adjudicate such dispute to the exclusion of all other Courts.</li>
                                            <li>This Agreement is subject to jurisdiction of courts at Goa.</li>
                                        </ul>
                                    </div> 
                                </section>
                            </div>
                        </div>
                    </div>
                </div><!-- End Page-content -->

                <footer class="footer"> <!-- footer start -->
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-sm-6">
                                <?php echo $date; ?> © Uniqbizz.
                            </div>
                            <div class="col-sm-6">
                                <div class="text-sm-end d-none d-sm-block">
                                    Design & Develop by Mirthcon
                                </div>
                            </div>
                        </div>
                    </div>
                </footer> <!-- footer end -->
                
            </div><!-- end main content-->
        
        </div><!-- END layout-wrapper -->
        <button onclick="topFunction()" class="scrollToTop scroll-btn show btn" id="back-to-top">
            <i class="ri-arrow-up-line"></i>
        </button>
        <!-- JAVASCRIPT -->
        <script src="assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
        <script src="assets/libs/simplebar/simplebar.min.js"></script>
        <script src="assets/libs/node-waves/waves.min.js"></script>
        <script src="assets/libs/feather-icons/feather.min.js"></script>
        <script src="assets/js/jquery/jquery-3.7.1.min.js"></script>
        <script src="assets/js/pages/remix-icons-listing.js"></script>
        <script src="assets/js/app.js"></script>
    </body>
</html>