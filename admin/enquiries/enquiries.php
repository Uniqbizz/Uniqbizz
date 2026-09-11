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
        <!-- Enquiries Css-->
        <link href="../assets/css/enquiries.css" id="app-style" rel="stylesheet" type="text/css" />
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
                            <div class="col-12">
                                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                    <h4 class="mb-sm-0 font-size-18">Enquiries</h4>
                                </div>
                            </div>
                        </div>
                        <!-- end page title -->
                        <div class="row rowAlignment">
                            <!-- NEW ENQUIRIES -->
                            <div class="cardWidth">
                                <div class="card rounded-4 p-3 cardHeight">
                                    <div class="d-flex align-items-center">

                                        <span class="cardHover cardHover1">
                                            <i class="fa-solid fa-user-plus fa-xl faIcon"></i>
                                        </span>

                                        <div class="ms-4">
                                            <h6 class="fontSize12 mb-1">New Enquiries</h6>

                                            <p
                                                class="fs-4 fw-bold mb-0"
                                                id="newEnquiriesCount"
                                            >
                                                0
                                            </p>
                                        </div>

                                    </div>
                                </div>
                            </div>


                            <!-- IN PROGRESS -->
                            <div class="cardWidth">
                                <div class="card rounded-4 p-3 cardHeight">
                                    <div class="d-flex align-items-center">

                                        <span class="cardHover cardHover2">
                                            <i class="fa-solid fa-spinner fa-xl faIcon"></i>
                                        </span>

                                        <div class="ms-4">
                                            <h6 class="fontSize12 mb-1">In Progress</h6>

                                            <p
                                                class="fs-4 fw-bold mb-0"
                                                id="inProgressCount"
                                            >
                                                0
                                            </p>
                                        </div>

                                    </div>
                                </div>
                            </div>


                            <!-- QUOTATION SENT -->
                            <div class="cardWidth">
                                <div class="card rounded-4 p-3 cardHeight">
                                    <div class="d-flex align-items-center">

                                        <span class="cardHover cardHover3">
                                            <i class="fa-solid fa-paper-plane fa-xl faIcon"></i>
                                        </span>

                                        <div class="ms-4">
                                            <h6 class="fontSize12 mb-1">Quotation Sent</h6>

                                            <p
                                                class="fs-4 fw-bold mb-0"
                                                id="quotationSentCount"
                                            >
                                                0
                                            </p>
                                        </div>

                                    </div>
                                </div>
                            </div>


                            <!-- AWAITING RESPONSE -->
                            <div class="cardWidth">
                                <div class="card rounded-4 p-3 cardHeight">
                                    <div class="d-flex align-items-center">

                                        <span class="cardHover cardHover4">
                                            <i class="fa-solid fa-clock fa-xl faIcon"></i>
                                        </span>

                                        <div class="ms-4">
                                            <h6 class="fontSize12 mb-1">Awaiting Response</h6>

                                            <p
                                                class="fs-4 fw-bold mb-0"
                                                id="awaitingResponseCount"
                                            >
                                                0
                                            </p>
                                        </div>

                                    </div>
                                </div>
                            </div>


                            <!-- CLOSED -->
                            <div class="cardWidth">
                                <div class="card rounded-4 p-3 cardHeight">
                                    <div class="d-flex align-items-center">

                                        <span class="cardHover cardHover5">
                                            <i class="fa-solid fa-circle-check fa-xl faIcon"></i>
                                        </span>

                                        <div class="ms-4">
                                            <h6 class="fontSize12 mb-1">Closed</h6>

                                            <p
                                                class="fs-4 fw-bold mb-0"
                                                id="closedCount"
                                            >
                                                0
                                            </p>
                                        </div>

                                    </div>
                                </div>
                            </div>

                        </div>
                        <!-- Enquiries Start -->
                        <!-- <div class="row d-flex justify-content-between">
                            <div class="col-xl-8 col-lg-8 col-md-8 col-sm-12 col-12 pb-3">
                                <nav role="navigation">
                                    <ul class="nav nav-underline border-bottom border-1 border-secondary-subtle d-flex justify-content-around" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link active" data-bs-toggle="tab" role="tab" href="#allEnquiries">All Enquiries</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" data-bs-toggle="tab" role="tab" href="#newEnquiry">New</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" data-bs-toggle="tab" role="tab" href="#inProgress">In Progress</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" data-bs-toggle="tab" role="tab" href="#quotationSent">Quotation Sent</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" data-bs-toggle="tab" role="tab" href="#awaitingResponse">Awaiting Response</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" data-bs-toggle="tab" role="tab" href="#closedEnquiry">Closed</a>
                                        </li>
                                    </ul>
                                </nav>
                            </div>
                            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-7 col-7 pb-3 ps-0">
                                <div class="d-flex justify-content-end dateRangeAlign">
                                    <div id="reportrange" class="bg-primary text-white px-3 py-2 w-100 text-center dateRange">
                                        <i class="fa fa-calendar"></i>&nbsp;
                                        <span id='selectedDate'></span> <i class="fa-solid fa-angle-down"></i>
                                    </div>
                                </div>
                            </div>
                        </div> -->
                        <div class="row d-flex justify-content-between">
                            <div class="col-xl-8 col-lg-8 col-md-8 col-sm-12 col-12 pb-3">

                                <nav role="navigation">

                                    <ul class="nav nav-underline border-bottom border-1 border-secondary-subtle d-flex justify-content-around"
                                        role="tablist">

                                        <li class="nav-item">
                                            <a class="nav-link active enquiryFilter"
                                            href="javascript:void(0)"
                                            data-status="">
                                                All Enquiries
                                            </a>
                                        </li>

                                        <li class="nav-item">
                                            <a class="nav-link enquiryFilter"
                                            href="javascript:void(0)"
                                            data-status="New Enquiry">
                                                New
                                            </a>
                                        </li>

                                        <li class="nav-item">
                                            <a class="nav-link enquiryFilter"
                                            href="javascript:void(0)"
                                            data-status="In Progress">
                                                In Progress
                                            </a>
                                        </li>

                                        <li class="nav-item">
                                            <a class="nav-link enquiryFilter"
                                            href="javascript:void(0)"
                                            data-status="Quotation Sent">
                                                Quotation Sent
                                            </a>
                                        </li>

                                        <li class="nav-item">
                                            <a class="nav-link enquiryFilter"
                                            href="javascript:void(0)"
                                            data-status="Awaiting Response">
                                                Awaiting Response
                                            </a>
                                        </li>

                                        <li class="nav-item">
                                            <a class="nav-link enquiryFilter"
                                            href="javascript:void(0)"
                                            data-status="Closed">
                                                Closed
                                            </a>
                                        </li>

                                    </ul>

                                </nav>

                            </div>
                            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-7 col-7 pb-3 ps-0">

                                <div class="d-flex justify-content-end dateRangeAlign">

                                    <div id="reportrange"
                                        class="bg-primary text-white px-3 py-2 w-100 text-center dateRange">

                                        <i class="fa fa-calendar"></i>&nbsp;

                                        <span id="selectedDate"></span>

                                        <i class="fa-solid fa-angle-down"></i>

                                    </div>

                                </div>

                            </div>
                        </div>
                        <!-- Enquiries end -->
                        <div class="tab-content" id='tableList'>
                            <div class="tab-pane fade card show active px-3 rounded-4" id="allHistory" role="tabpanel">
                                <div class="col-lg-12 py-3">
                                    <div class="table-responsive table-desi">
                                        <!-- <table class="table table-hover" id="user_table1">
                                            <thead>
                                                <tr>
                                                    <th class="ceterText fw-bolder font-size-13">Enquiry ID</th>
                                                    <th class="ceterText fw-bolder font-size-13">Customer Details</th>
                                                    <th class="ceterText fw-bolder font-size-13">Destination & Dates</th>
                                                    <th class="ceterText fw-bolder font-size-13">Submitted On</th>
                                                    <th class="ceterText fw-bolder font-size-13">Status</th>
                                                    <th class="ceterText fw-bolder font-size-13">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td class="align-content-center">
                                                        <p class="text-danger fontSize12 fw-bold mb-0">BQ10245</p>
                                                    </td>
                                                    <td class="align-content-center">
                                                        <div class="">
                                                            <p class="fontSize12 mb-1 fw-bold">Devika Naik</p>
                                                            <p class="fontSize12 mb-1">
                                                                <i class="fa-solid fa-phone me-2"></i>
                                                                +91 7289564566
                                                            </p>
                                                            <p class="fontSize12 mb-1">
                                                                <i class="fa-regular fa-envelope me-2"></i>
                                                                devika.naik@gmail.com
                                                            </p>
                                                        </div>
                                                    </td>
                                                    <td class="align-content-center">
                                                        <div class="">
                                                            <p class="fontSize12 mb-1 fw-bold">Varanasi</p>
                                                            <p class="fontSize12 mb-1">
                                                                <span>20 Jul 2026</span> - <span>24 Jul 2026</span>
                                                            </p>
                                                            <p class="fontSize12 mb-1">
                                                                <span>4N</span> / <span>5D</span>
                                                            </p>
                                                        </div>
                                                    </td>
                                                    <td class="align-content-center">
                                                        <div class="">
                                                            <p class="fontSize12 mb-1 fw-bold">18 May 2026</p>
                                                            <p class="fontSize12 mb-1">
                                                                10:15 AM
                                                            </p>
                                                        </div>
                                                    </td>
                                                    <td class="align-content-center">
                                                        <div class="enquiryStatusBtn enquiryStatusBtn1">New Enquiry</div>
                                                    </td>
                                                    <td class="align-content-center">
                                                        <div class="enquiryEditBtn">Edit</div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="align-content-center">
                                                        <p class="text-danger fontSize12 fw-bold mb-0">BQ10245</p>
                                                    </td>
                                                    <td class="align-content-center">
                                                        <div class="">
                                                            <p class="fontSize12 mb-1 fw-bold">Devika Naik</p>
                                                            <p class="fontSize12 mb-1">
                                                                <i class="fa-solid fa-phone me-2"></i>
                                                                +91 7289564566
                                                            </p>
                                                            <p class="fontSize12 mb-1">
                                                                <i class="fa-regular fa-envelope me-2"></i>
                                                                devika.naik@gmail.com
                                                            </p>
                                                        </div>
                                                    </td>
                                                    <td class="align-content-center">
                                                        <div class="">
                                                            <p class="fontSize12 mb-1 fw-bold">Varanasi</p>
                                                            <p class="fontSize12 mb-1">
                                                                <span>20 Jul 2026</span> - <span>24 Jul 2026</span>
                                                            </p>
                                                            <p class="fontSize12 mb-1">
                                                                <span>4N</span> / <span>5D</span>
                                                            </p>
                                                        </div>
                                                    </td>
                                                    <td class="align-content-center">
                                                        <div class="">
                                                            <p class="fontSize12 mb-1 fw-bold">18 May 2026</p>
                                                            <p class="fontSize12 mb-1">
                                                                10:15 AM
                                                            </p>
                                                        </div>
                                                    </td>
                                                    <td class="align-content-center">
                                                        <div class="enquiryStatusBtn enquiryStatusBtn2">In Progress</div>
                                                    </td>
                                                    <td class="align-content-center">
                                                        <div class="enquiryEditBtn">Edit</div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="align-content-center">
                                                        <p class="text-danger fontSize12 fw-bold mb-0">BQ10245</p>
                                                    </td>
                                                    <td class="align-content-center">
                                                        <div class="">
                                                            <p class="fontSize12 mb-1 fw-bold">Devika Naik</p>
                                                            <p class="fontSize12 mb-1">
                                                                <i class="fa-solid fa-phone me-2"></i>
                                                                +91 7289564566
                                                            </p>
                                                            <p class="fontSize12 mb-1">
                                                                <i class="fa-regular fa-envelope me-2"></i>
                                                                devika.naik@gmail.com
                                                            </p>
                                                        </div>
                                                    </td>
                                                    <td class="align-content-center">
                                                        <div class="">
                                                            <p class="fontSize12 mb-1 fw-bold">Varanasi</p>
                                                            <p class="fontSize12 mb-1">
                                                                <span>20 Jul 2026</span> - <span>24 Jul 2026</span>
                                                            </p>
                                                            <p class="fontSize12 mb-1">
                                                                <span>4N</span> / <span>5D</span>
                                                            </p>
                                                        </div>
                                                    </td>
                                                    <td class="align-content-center">
                                                        <div class="">
                                                            <p class="fontSize12 mb-1 fw-bold">18 May 2026</p>
                                                            <p class="fontSize12 mb-1">
                                                                10:15 AM
                                                            </p>
                                                        </div>
                                                    </td>
                                                    <td class="align-content-center">
                                                        <div class="enquiryStatusBtn enquiryStatusBtn3">Quotation Sent</div>
                                                    </td>
                                                    <td class="align-content-center">
                                                        <div class="enquiryEditBtn">Edit</div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="align-content-center">
                                                        <p class="text-danger fontSize12 fw-bold mb-0">BQ10245</p>
                                                    </td>
                                                    <td class="align-content-center">
                                                        <div class="">
                                                            <p class="fontSize12 mb-1 fw-bold">Devika Naik</p>
                                                            <p class="fontSize12 mb-1">
                                                                <i class="fa-solid fa-phone me-2"></i>
                                                                +91 7289564566
                                                            </p>
                                                            <p class="fontSize12 mb-1">
                                                                <i class="fa-regular fa-envelope me-2"></i>
                                                                devika.naik@gmail.com
                                                            </p>
                                                        </div>
                                                    </td>
                                                    <td class="align-content-center">
                                                        <div class="">
                                                            <p class="fontSize12 mb-1 fw-bold">Varanasi</p>
                                                            <p class="fontSize12 mb-1">
                                                                <span>20 Jul 2026</span> - <span>24 Jul 2026</span>
                                                            </p>
                                                            <p class="fontSize12 mb-1">
                                                                <span>4N</span> / <span>5D</span>
                                                            </p>
                                                        </div>
                                                    </td>
                                                    <td class="align-content-center">
                                                        <div class="">
                                                            <p class="fontSize12 mb-1 fw-bold">18 May 2026</p>
                                                            <p class="fontSize12 mb-1">
                                                                10:15 AM
                                                            </p>
                                                        </div>
                                                    </td>
                                                    <td class="align-content-center">
                                                        <div class="enquiryStatusBtn enquiryStatusBtn4">Awaiting Response</div>
                                                    </td>
                                                    <td class="align-content-center">
                                                        <div class="enquiryEditBtn">Edit</div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="align-content-center">
                                                        <p class="text-danger fontSize12 fw-bold mb-0">BQ10245</p>
                                                    </td>
                                                    <td class="align-content-center">
                                                        <div class="">
                                                            <p class="fontSize12 mb-1 fw-bold">Devika Naik</p>
                                                            <p class="fontSize12 mb-1">
                                                                <i class="fa-solid fa-phone me-2"></i>
                                                                +91 7289564566
                                                            </p>
                                                            <p class="fontSize12 mb-1">
                                                                <i class="fa-regular fa-envelope me-2"></i>
                                                                devika.naik@gmail.com
                                                            </p>
                                                        </div>
                                                    </td>
                                                    <td class="align-content-center">
                                                        <div class="">
                                                            <p class="fontSize12 mb-1 fw-bold">Varanasi</p>
                                                            <p class="fontSize12 mb-1">
                                                                <span>20 Jul 2026</span> - <span>24 Jul 2026</span>
                                                            </p>
                                                            <p class="fontSize12 mb-1">
                                                                <span>4N</span> / <span>5D</span>
                                                            </p>
                                                        </div>
                                                    </td>
                                                    <td class="align-content-center">
                                                        <div class="">
                                                            <p class="fontSize12 mb-1 fw-bold">18 May 2026</p>
                                                            <p class="fontSize12 mb-1">
                                                                10:15 AM
                                                            </p>
                                                        </div>
                                                    </td>
                                                    <td class="align-content-center">
                                                        <div class="enquiryStatusBtn enquiryStatusBtn5">Advance Received</div>
                                                    </td>
                                                    <td class="align-content-center">
                                                        <div class="enquiryEditBtn">Edit</div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="align-content-center">
                                                        <p class="text-danger fontSize12 fw-bold mb-0">BQ10245</p>
                                                    </td>
                                                    <td class="align-content-center">
                                                        <div class="">
                                                            <p class="fontSize12 mb-1 fw-bold">Devika Naik</p>
                                                            <p class="fontSize12 mb-1">
                                                                <i class="fa-solid fa-phone me-2"></i>
                                                                +91 7289564566
                                                            </p>
                                                            <p class="fontSize12 mb-1">
                                                                <i class="fa-regular fa-envelope me-2"></i>
                                                                devika.naik@gmail.com
                                                            </p>
                                                        </div>
                                                    </td>
                                                    <td class="align-content-center">
                                                        <div class="">
                                                            <p class="fontSize12 mb-1 fw-bold">Varanasi</p>
                                                            <p class="fontSize12 mb-1">
                                                                <span>20 Jul 2026</span> - <span>24 Jul 2026</span>
                                                            </p>
                                                            <p class="fontSize12 mb-1">
                                                                <span>4N</span> / <span>5D</span>
                                                            </p>
                                                        </div>
                                                    </td>
                                                    <td class="align-content-center">
                                                        <div class="">
                                                            <p class="fontSize12 mb-1 fw-bold">18 May 2026</p>
                                                            <p class="fontSize12 mb-1">
                                                                10:15 AM
                                                            </p>
                                                        </div>
                                                    </td>
                                                    <td class="align-content-center">
                                                        <div class="enquiryStatusBtn enquiryStatusBtn6">Closed</div>
                                                    </td>
                                                    <td class="align-content-center">
                                                        <div class="enquiryEditBtn">Edit</div>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table> -->
                                        <table class="table table-hover" id="user_table1">
                                            <thead>
                                                <tr>
                                                    <th class="ceterText fw-bolder font-size-13">Enquiry ID</th>
                                                    <th class="ceterText fw-bolder font-size-13">Customer Details</th>
                                                    <th class="ceterText fw-bolder font-size-13">Destination & Dates</th>
                                                    <th class="ceterText fw-bolder font-size-13">Submitted On</th>
                                                    <th class="ceterText fw-bolder font-size-13">Updated On</th>
                                                    <th class="ceterText fw-bolder font-size-13">Status</th>
                                                    <th class="ceterText fw-bolder font-size-13">Action</th>
                                                </tr>
                                            </thead>

                                            <tbody></tbody>
                                        </table>
                                        <!-- pegination start -->
                                        <div class="center text-center" id="pagination_row"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
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
        <!-- Date Range Script -->
        <script type="text/javascript">
            // $(function() {

            //     // var start = moment().subtract(29, 'days');
            //     // var end = moment();
            //     var start = moment("<?= $mindate ?>", "YYYY-MM-DD");
            //     var end = moment("<?= $maxdate ?>", "YYYY-MM-DD");

            //     function cb(start, end) {
            //         $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
            //     }

            //     $('#reportrange').daterangepicker({
            //         startDate: start,
            //         endDate: end,
            //         ranges: {
            //             'Today': [moment(), moment()],
            //             'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
            //             'Last 7 Days': [moment().subtract(6, 'days'), moment()],
            //             'Last 30 Days': [moment().subtract(29, 'days'), moment()],
            //             'This Month': [moment().startOf('month'), moment().endOf('month')],
            //             'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
            //         }
            //     }, cb);

            //     cb(start, end);

            // });
            $(function() {

                var start = moment("<?= $mindate ?>", "YYYY-MM-DD");

                var end = moment("<?= $maxdate ?>", "YYYY-MM-DD");


                function cb(start, end) {

                    /*
                    =====================================
                    DISPLAY DATE
                    =====================================
                    */

                    $('#reportrange span').html(

                        start.format('MMMM D, YYYY') +
                        ' - ' +
                        end.format('MMMM D, YYYY')

                    );


                    /*
                    =====================================
                    STORE MYSQL FORMAT
                    =====================================
                    */

                    selectedStartDate = start.format('YYYY-MM-DD');

                    selectedEndDate = end.format('YYYY-MM-DD');


                    /*
                    =====================================
                    RELOAD DATATABLE
                    =====================================
                    */

                    if ($.fn.DataTable.isDataTable('#user_table1')) {

                        $('#user_table1')
                            .DataTable()
                            .ajax
                            .reload();

                    }

                }


                $('#reportrange').daterangepicker({

                    startDate: start,

                    endDate: end,

                    ranges: {

                        'Today': [
                            moment(),
                            moment()
                        ],

                        'Yesterday': [
                            moment().subtract(1, 'days'),
                            moment().subtract(1, 'days')
                        ],

                        'Last 7 Days': [
                            moment().subtract(6, 'days'),
                            moment()
                        ],

                        'Last 30 Days': [
                            moment().subtract(29, 'days'),
                            moment()
                        ],

                        'This Month': [
                            moment().startOf('month'),
                            moment().endOf('month')
                        ],

                        'Last Month': [
                            moment()
                                .subtract(1, 'month')
                                .startOf('month'),

                            moment()
                                .subtract(1, 'month')
                                .endOf('month')
                        ]

                    }

                }, cb);


                /*
                =====================================
                INITIAL DATE DISPLAY
                =====================================
                */

                cb(start, end);

            });
        </script>
        <!-- Date Range Script -->
        <script>
            let selectedStatus = '';
            let startDate = '';
            let endDate = '';
            //table data with filters
            let enquiryTable = $('#user_table1').DataTable({

                processing: true,

                serverSide: true,

                responsive: true,

                pageLength: 10,

                ajax: {

                    url: 'ajax/get_enquiries.php',

                    type: 'POST',

                    data: function (d) {

                        d.status = selectedStatus;

                        d.start_date = startDate;

                        d.end_date = endDate;

                    }

                },

                columns: [

                    {
                        data: 'enquiry_id'
                    },

                    {
                        data: 'customer_details',
                        orderable: false
                    },

                    {
                        data: 'destination_details',
                        orderable: false
                    },

                    {
                        data: 'submitted_on'
                    },
                    {
                        data: 'updated_on'
                    },

                    {
                        data: 'status',
                        orderable: false
                    },

                    {
                        data: 'action',
                        orderable: false,
                        searchable: false
                    }

                ],
                columnDefs: [
                    {
                        targets: '_all',
                        createdCell: function (td) {
                            $(td).addClass('align-content-center');
                        }
                    }
                ],
                order: [
                    [3, 'desc']
                ]

            });

            $(document).on('click', '.enquiryFilter', function () {

                $('.enquiryFilter').removeClass('active');

                $(this).addClass('active');

                selectedStatus = $(this).data('status');

                enquiryTable.ajax.reload();

                loadEnquiryCounts();

            });
            //load card data
            function loadEnquiryCounts() {
                $.ajax({
                    url: 'ajax/get_enquiry_counts.php',
                    type: 'POST',
                    dataType: 'json',
                    success: function (response) {
                        if (response.status) {
                            $('#newEnquiriesCount').text(response.data.new_enquiries);
                            $('#inProgressCount').text(response.data.in_progress);
                            $('#quotationSentCount').text(response.data.quotation_sent);
                            $('#awaitingResponseCount').text(response.data.awaiting_response);
                            $('#closedCount').text(response.data.closed );
                        }
                    },
                    error: function (xhr, status, error) {
                        console.error(
                            'Error loading enquiry counts:',
                            error
                        );
                    }
                });
            }
            $(document).ready(function () {

                loadEnquiryCounts();

            });
        </script>
    </body>
</html>