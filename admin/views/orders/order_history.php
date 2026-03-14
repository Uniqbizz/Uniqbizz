<?php
session_start();

if (!isset($_SESSION['username'])) {
    echo '<script>location.href = "../../login.php";</script>';
}
$date = date('Y'); 
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order History</title>
    <!-- App favicon -->
    <link rel="shortcut icon" href="../../assets/images/fav.png">
    <!-- custom css file -->
    <!-- <link href="../../assets/css/styles.css" rel="stylesheet" type="text/css" /> -->
    <!-- Bootstrap Css -->
    <link href="../../assets/css/bootstrap.min.css" id="bootstrap-style" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="../../assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="../../assets/css/app.min.css" id="app-style" rel="stylesheet" type="text/css" />
    <!-- Css-->
    <link href="../../assets/css/loadingScreen.css" id="app-style" rel="stylesheet" type="text/css" />
    <!-- App js -->
    <!-- <script src="assets/js/plugin.js"></script> -->
    <!-- DataTables -->
    <link href="../../assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />

    <!-- Responsive datatable examples -->
    <link href="../../assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Date Range Picker CSS Start -->
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    <!-- Date Range Picker CSS End -->

    <style>
        .selected-date {
            background-color: #dfeaff !important;
            /* Light blue highlight */
            border: 2px solid #007bff !important;
            /* Blue border */
            border-radius: 5px;
        }

        .cardHover:hover {
            background-color: #556ee6 !important;
            border-radius: 6px !important;
            /* padding: 4px !important; */
            border: none !important;
        }

        .faIcon {
            padding: 21px 17px 21px 17px !important;
        }

        .faIcon:hover {
            color: #fff !important
        }

        .pera {
            font-size: 10px !important;
            font-weight: 500 !important;
        }

        .bookingDate {
            width: 130px !important;
        }

        .dateRange {
            border-radius: 14px !important;
        }

        @media screen and (min-width: 993px) and (max-width: 1180px) {
            .cardText {
                font-size: 12px !important;
            }

            .cardProPic {
                width: 35px !important;
                height: 35px !important;
            }

            .card-Img1 {
                width: 70px !important;
                height: 55px !important;
            }

        }

        @media screen and (min-width: 768px) and (max-width: 960px) {
            .cardText {
                font-size: 12px !important;
            }

            .cardProPic {
                width: 35px !important;
                height: 35px !important;
            }

            .card-Img1 {
                width: 70px !important;
                height: 55px !important;
            }
        }

        @media screen and (min-width: 320px) and (max-width: 485px) {
            .cardText {
                font-size: 11px !important;
            }

            .cardProPic {
                width: 35px !important;
                height: 35px !important;
            }

            .card-Img1 {
                width: 65px !important;
                height: 50px !important;
            }
        }

        @media only screen and (max-width: 1180px) {
            .rowAlign {
                display: block !important;
            }

            .dateRangeAlign {
                display: flex !important;
                justify-content: left !important;
            }

        }
    </style>
</head>

<body data-sidebar="dark">
    <div class="layout-wrapper">
        <?php
            // top header logo, hamberger menu, fullscreen icon, profile
            include_once '../../header.php';

            // sidebar navigation menu 
            include_once '../../sidebar.php';

            require '../../connect.php';

            include '../../models/orders/order_history_cards.php';
        ?>
        <!-- data load from models file -->
        <div class="layout-wrapper">
            <div class="main-content">
                <div class="page-content">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-12">
                                <div class="card rounded-4 p-3">
                                    <div class="d-flex align-items-center">
                                        <span class="bg-primary-subtle text-primary-emphasis rounded-3 cardHover">
                                            <i class="fa-solid fa-hourglass-end fa-xl faIcon" style="color: #222c5c;"></i>
                                        </span>
                                        <div class="ms-4">
                                            <h3 class="mb-0"><?= $pending_booking_count ?></h3>
                                            <p class="text-muted mb-0 pera">Pending Booking</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-12">
                                <div class="card rounded-4 p-3">
                                    <div class="d-flex align-items-center">
                                        <span class="bg-primary-subtle text-primary-emphasis rounded-3 cardHover">
                                            <i class="fa-solid fa-plane-departure fa-xl faIcon" style="color: #222c5c;"></i>
                                            <!-- <i class="fa-solid fa-hourglass-end fa-xl faIcon" style="color: #222c5c;"></i> -->
                                        </span>
                                        <div class="ms-4">
                                            <h3 class="mb-0"><?= $in_transit_booking_count ?></h3>
                                            <p class="text-muted mb-0 pera">In Transit Booking</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-12">
                                <div class="card rounded-4 p-3">
                                    <div class="d-flex align-items-center">
                                        <span class="bg-primary-subtle text-primary-emphasis rounded-3 cardHover">
                                            <i class="fa-solid fa-check fa-xl faIcon" style="color: #222c5c;"></i>
                                        </span>
                                        <div class="ms-4">
                                            <h3 class="mb-0"><?= $completed_booking_count ?></h3>
                                            <p class="text-muted mb-0 pera">Completed Booking</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-12">
                                <div class="card rounded-4 p-3">
                                    <div class="d-flex align-items-center">
                                        <span class="bg-primary-subtle text-primary-emphasis rounded-3 cardHover">
                                            <i class="fa-solid fa-plane-slash fa-xl faIcon" style="color: #222c5c;"></i>
                                        </span>
                                        <div class="ms-4">
                                            <h3 class="mb-0"><?= $canceled_booking_count ?></h3>
                                            <p class="text-muted mb-0 pera">Canceled Booking</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-12">
                                <div class="card rounded-4 p-3">
                                    <div class="d-flex align-items-center">
                                        <span class="bg-primary-subtle text-primary-emphasis rounded-3 cardHover">
                                            <i class="fa-solid fa-hourglass-half fa-xl faIcon" style="color: #222c5c;"></i>
                                        </span>
                                        <div class="ms-4">
                                            <h3 class="mb-0">&#8377;<?= $pending_payment_amt ?></h3>
                                            <p class="text-muted mb-0 pera">Pending Payment</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-12">
                                <div class="card rounded-4 p-3">
                                    <div class="d-flex align-items-center">
                                        <span class="bg-primary-subtle text-primary-emphasis rounded-3 cardHover">
                                            <i class="fa-solid fa-check fa-xl faIcon" style="color: #222c5c;"></i>
                                        </span>
                                        <div class="ms-4">
                                            <h3 class="mb-0">&#8377;<?= $completed_payment_amt ?></h3>
                                            <p class="text-muted mb-0 pera">Completed Payment</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Calender Start -->
                        <div class="row">
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12" id="eventCalender">
                                <div class="card rounded-4 d-grid p-3">
                                    <div id="btn-new-event"></div>
                                    <div id='locale-selector' class="d-none"></div>

                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                                <div class="card rounded-4 p-3 pt-2" id="bookingCardData">

                                </div>
                            </div>
                        </div>

                        <!-- Calender End -->

                        <!-- Order History Start -->
                        <div class="row">
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 pb-3">
                                <nav role="navigation">
                                    <ul class="nav nav-underline border-bottom border-1 border-secondary-subtle d-flex justify-content-around" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link active" data-bs-toggle="tab" role="tab" href="#allHistory">All</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" data-bs-toggle="tab" role="tab" href="#pendingHistory">Pending</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" data-bs-toggle="tab" role="tab" href="#bookedHistory">Booked</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" data-bs-toggle="tab" role="tab" href="#canceledHistory">Canceled</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" data-bs-toggle="tab" role="tab" href="#refundHistory">Refund</a>
                                        </li>
                                    </ul>
                                </nav>
                            </div>
                            <div class="col-xl-2 col-lg-2 col-md-2 col-sm-5 col-5 pb-3 px-0">
                                <div class="d-flex justify-content-center">
                                    <div id="addHistory" class="bg-primary px-3 py-2 text-center rounded-4">
                                        <a href="placeOrder.php" class="text-white"><i class="fa fa-pencil-square me-2"></i>Place Order</a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-7 col-7 pb-3 ps-0">
                                <div class="d-flex justify-content-end dateRangeAlign">
                                    <div id="reportrange" class="bg-primary text-white px-3 py-2 w-100 text-center dateRange">
                                        <i class="fa fa-calendar"></i>&nbsp;
                                        <span id='selectedDate'></span> <i class="fa-solid fa-angle-down"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Order History end -->
                        <div class="tab-content" id='tableList'>
                            <div class="tab-pane fade card show active px-3 rounded-4" id="allHistory" role="tabpanel">
                                <div class="col-lg-12 py-3">
                                    <div class="table-responsive table-desi">
                                        <!-- data load from models file -->
                                        <?php include '../../models/orders/all_booking_table.php'?>
                                        <!-- pegination start -->
                                        <div class="center text-center" id="pagination_row"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade card show px-3 rounded-4" id="pendingHistory" role="tabpanel">
                                <div class="col-lg-12 py-3">
                                    <div class="table-responsive table-desi">
                                        <!-- data load from models file -->
                                         <?php include '../../models/orders/pending _booking_table.php'?>
                                        <!-- pegination start -->
                                        <div class="center text-center" id="pagination_row"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade card show px-3 rounded-4" id="bookedHistory" role="tabpanel">
                                <div class="col-lg-12 py-3">
                                    <div class="table-responsive table-desi">
                                        <!-- data load from models file -->
                                        <?php include '../../models/orders/booked_booking_table.php'?>
                                        <!-- pegination start -->
                                        <div class="center text-center" id="pagination_row"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade card show px-3 rounded-4" id="canceledHistory" role="tabpanel">
                                <div class="col-lg-12 py-3">
                                    <div class="table-responsive table-desi">
                                        <!-- data load from models file -->
                                         <?php include '../../models/orders/cancelled_booking_table.php'?>
                                        <!-- pegination start -->
                                        <div class="center text-center" id="pagination_row"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade card show px-3 rounded-4" id="refundHistory" role="tabpanel">
                                <div class="col-lg-12 py-3">
                                    <div class="table-responsive table-desi">
                                        <!-- data load from models file -->
                                         <?php include '../../models/orders/refund_booking_table.php'?>
                                        <!-- pegination start -->
                                        <div class="center text-center" id="pagination_row"></div>
                                    </div>
                                    <div class="row d-flex justify-content-center d-none" id="refundAmt">
                                        <div class="col-md-8 col-sm-10">
                                            <div class="row d-flex justify-content-center">
                                                <div class="col-md-6 col-sm-6">
                                                    <h5 class="fw-bolder">Paid Refund: <span>&#8377; 10000</span></h5>
                                                </div>
                                                <div class="col-md-6 col-sm-6">
                                                    <h5 class="fw-bolder">Pending Refund: <span>&#8377; 10000</span></h5>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php include_once "../../footer.php" ?>
            </div>
        </div>
        <!-- Refund Modal -->
        <div class="modal fade" id="refundModal" tabindex="-1" aria-labelledby="refundModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content rounded-4">
                    <div class="modal-header">
                        <h5 class="modal-title" id="refundModalLabel">Initiate Refund</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        <form id="refundForm" data-order-id="">
                            <div class="mb-3">
                                <label class="form-label d-block">Is Refund Amount Applicable?</label>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input refund-applicable" type="radio" name="isRefundApplicable" id="refundYes" value="yes" checked>
                                    <label class="form-check-label" for="refundYes">Yes</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input refund-applicable" type="radio" name="isRefundApplicable" id="refundNo" value="no">
                                    <label class="form-check-label" for="refundNo">No</label>
                                </div>
                            </div>

                            <div class="mb-3" id="refundAmountGroup">
                                <label for="refundAmount" class="form-label">Refund Amount</label>
                                <input type="number" class="form-control" id="refundAmount" placeholder="Enter amount">
                            </div>

                            <div class="mb-3">
                                <label for="refundReason" class="form-label">Reason</label>
                                <textarea class="form-control" id="refundReason" rows="3" placeholder="Enter refund reason..."></textarea>
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-primary">Submit Refund</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- Cancel Message Modal -->
        <div class="modal fade" id="cancelStatusModal" tabindex="-1" aria-labelledby="cancelStatusModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content rounded-4">
                    <div class="modal-header">
                        <h5 class="modal-title" id="cancelStatusModalLabel">Booking Canceled</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        <p id="cancelMessage" class="text-secondary">Loading message...</p>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END layout-wrapper -->
    <!--start back-to-top-->
    <button onclick="topFunction()" class="scrollToTop scroll-btn show btn" id="back-to-top">
        <i class="mdi mdi-arrow-up"></i>
    </button>
    <!--end back-to-top-->
    <!-- JAVASCRIPT -->
    <script src="../../assets/libs/jquery/jquery.min.js"></script>
    <script src="../../assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../../assets/libs/metismenu/metisMenu.min.js"></script>
    <script src="../../assets/libs/simplebar/simplebar.min.js"></script>
    <script src="../../assets/libs/node-waves/waves.min.js"></script>
    <!-- Required datatable js -->
    <script src="../../assets/libs/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="../../assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>

    
    <!-- Responsive examples -->
    <script src="../../assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
    <script src="../../assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js"></script>
    <!-- Calendar init -->
    <script src="../../assets/libs/fullcalendar/index.global.min.js"></script>

    <!-- Date Range Picker Script Start -->
    <!-- <script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script> -->
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <!-- Date Range Picker Script End -->

    <!-- App js -->
    <script src="../../assets/js/app.js"></script>
    <script src="../../resources/common_resources/top_function.js"></script>
    <script src ="../../resources/orders/order_custom.js"></script>
    <!-- Date Range Script -->
</body>

</html>