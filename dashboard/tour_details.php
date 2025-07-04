<?php
include_once 'dashboard_user_details.php';
$order_id = $_GET['id'] ?? null;
//booking details
$sql_book = "SELECT * FROM bookings WHERE id = " . $order_id . "";
$stmtbook = $conn->prepare($sql_book);
$stmtbook->execute();
$booking = $stmtbook->fetch(PDO::FETCH_ASSOC);

//booking billing details
$sql_book_bill = "SELECT * FROM booking_direct_bill WHERE bookings_id = " . (int)$order_id . "";
$stmt_book_bill = $conn->prepare($sql_book_bill);
$stmt_book_bill->execute();
$booking_bill = $stmt_book_bill->fetch(PDO::FETCH_ASSOC);

//package name
$sql_pack = "SELECT * FROM package WHERE id = " . (int)$booking['package_id'] . "";
$stmt_pack = $conn->prepare($sql_pack);
$stmt_pack->execute();
$booking_pack = $stmt_pack->fetch(PDO::FETCH_ASSOC);

//member details
$sql_pack = "SELECT * FROM booking_member_details WHERE bookings_id = :order_id";
$stmt_pack = $conn->prepare($sql_pack);
$stmt_pack->bindParam(':order_id', $order_id, PDO::PARAM_INT);
$stmt_pack->execute();
$member = $stmt_pack->fetchAll(PDO::FETCH_ASSOC); // Fetch all rows

//get pictures
$sql_pack_pic = "SELECT * FROM package_pictures WHERE package_id = " . (int)$booking['package_id'] . " LIMIT 1 ";
$stmt_pack_pic = $conn->prepare($sql_pack_pic);
$stmt_pack_pic->execute();
$pictures = $stmt_pack_pic->fetchAll(PDO::FETCH_ASSOC); // Fetch all rows

?>
<!doctype html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg" data-sidebar-image="none" data-preloader="disable">

<head>
    <meta charset="utf-8" />
    <title>Dashboard | Tour History</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- App favicon -->
    <link rel="shortcut icon" href="assets/images/fav.png">

    <!-- jsvectormap css -->
    <link href="assets/libs/jsvectormap/css/jsvectormap.min.css" rel="stylesheet" type="text/css" />

    <!--Swiper slider css-->
    <link href="assets/libs/swiper/swiper-bundle.min.css" rel="stylesheet" type="text/css" />

    <!-- DataTables -->
    <link href="assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <!-- Responsive datatable examples -->
    <link href="assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css" />

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
    <!-- font-awesome -->
    <link rel="stylesheet" href="assets/fontawesome/css/all.min.css" />
    <style>
        @media only screen and (max-width:575px) {
            .qrCode {
                height: 100% !important;
                width: 250px !important;
            }

            .contDetails {
                display: grid !important;
                justify-content: center !important;
            }
        }
    </style>
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
                            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                <h4 class="mb-sm-0">View Tour Invoice</h4>

                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="tour_history.php">Tour History</a></li>
                                        <li class="breadcrumb-item active">View Tour Invoice</li>
                                    </ol>
                                </div>

                            </div>
                        </div>
                    </div>
                    <!-- end page title -->
                    <div class="row">
                        <div class="card">
                            <div class="col-lg-12 col-md-12 col-sm-12 d-flex justify-content-end pb-3 pt-3 mb-4" style="border-bottom: 1px solid #DDDDDD">

                                <button id="generatePDF" class="bg-success text-white rounded-3 border-0 p-2">
                                    <i class="mdi mdi-download font-size-16 text-white me-1"></i>
                                    Download Invoice
                                </button>
                            </div>
                            <div class="d-flex justify-content-center" id="htmlContent">
                                <div class="row px-2 pb-2 mb-5 rounded-5 border border-dark" style="width:700px;">
                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                        <div class="row">
                                            <div class="col-lg-12 col-md-12 col-sm-12 p-3 d-flex justify-content-between">
                                                <img src="assets/images/uniqbizz_logo.png" alt="uniqbizz logo" height="20px;" class="mt-4">
                                                <img src="assets/images/bizz_logo.png" alt="uniqbizz logo" height="50px" width="100px">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                        <div class="row">
                                            <div class="col-lg-6 col-md-6 col-sm-6 col-6 pt-3" style="padding-left: 50px">
                                                <h5 style="color: #000; font-size: bolder">Invoice No. <strong> <?php echo $booking['order_id'] ?></strong></h5>
                                                <h5 style="color: #000; font-size: bolder">Payment: <?php
                                                                                                    if ($booking_bill['status'] == 1) {
                                                                                                        echo '<strong style="color:green">Paid';
                                                                                                    } ?>
                                                    <?php if ($booking_bill['status'] == 0) {
                                                        echo '<strong style="color:orange">Pending';
                                                    } ?></strong></h5>
                                                <p style="color: #000; font-size: bolder; font-weight: 600"> Transaction ID #<strong><?php echo $booking_bill['paymentid'] ?></strong></p>
                                                <p class="text-dark">Invoice: Date: <?php echo $booking_bill['created_at'] ?></p>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-sm-6 col-6 text-end pt-3" style="padding-right: 42px">
                                                <h5 style="color: #000; font-size: bolder">₹ <strong> <?php echo number_format((float)$booking_bill['final_price'], 2, '.', '') ?></strong></h5>
                                                <?php
                                                // if ( $booking_bill['gst_status'] == "1" ){
                                                //     echo '<p class="textColor" style="text-align: right; padding:5px 0px; color:#473e3e; ">GSTIN - '.$booking_bill['gst_number'].'</p>';
                                                // }
                                                ?>
                                            </div>
                                            <div class="col-lg-11 col-md-11 col-sm-11 col-11 rounded-5 border border-dark" style="margin: auto;">
                                                <div class="d-flex justify-content-evenly border-bottom border-dark pt-2">
                                                    <h5 class="text-dark fw-bold text-center">Destination</h5>
                                                    <h5 class="text-dark fw-bold text-center">Customer Details</h5>
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-4 col-md-4 col-sm-3 col-12 pt-3 pb-3">
                                                        <?php
                                                        foreach ($pictures as $key => $picture) {
                                                            echo '<div class="preview-images-zone qrCode" style="height:150px; width:100%; position:relative; margin-right:1px; display:inline-flex;">
                                                                        <img src="../../' . $picture['image'] . '" style="width: 200px; height: 100%; padding: 5px;object-fit:cover">
                                                                    </div>
                                                                    ';
                                                        }
                                                        ?>
                                                    </div>
                                                    <div class="col-lg-8 col-md-8 col-sm-9 col-12 pt-3">
                                                        <div class="row">
                                                            <div class="col-lg-6 col-md-6 col-sm-6 col-6">
                                                                <p class="ms-3 text-dark fs-5 mb-n1">Corder ID</p>
                                                                <p class="ms-3 text-dark fs-5 mb-n1">Customer ID</p>
                                                                <p class="ms-3 text-dark fs-5 mb-n1">Name</p>
                                                                <p class="ms-3 text-dark fs-5 mb-n1">Email</p>
                                                                <p class="ms-3 text-dark fs-5 mb-n1">Phone No</p>
                                                                <p class="ms-3 text-dark fs-5 mb-n1">Package</p>
                                                                <p class="ms-3 text-dark fs-5">Departure Date</p>
                                                            </div>
                                                            <div class="col-lg-6 col-md-6 col-sm-6 col-6">
                                                                <p class="ms-2 text-dark fs-5 mb-n1">#<?php echo $booking['order_id']; ?> </p>
                                                                <?php if ($booking['customer_id'] == "null") {  ?>
                                                                    <p class="ms-2 text-dark fs-5 mb-n1">-</p>
                                                                    <p class="ms-2 text-dark fs-5 mb-n1"><?php echo $booking['name']; ?></p>
                                                                    <p class="ms-2 text-dark fs-5 mb-n1"><?php echo $booking['email']; ?></p>
                                                                    <p class="ms-2 text-dark fs-5 mb-n1"><?php echo $booking['phone']; ?></p>
                                                                    <p class="ms-2 text-dark fs-5 mb-n1"><?php echo $package['name']; ?></p>
                                                                    <p class="ms-2 text-dark fs-5"><?php echo $tour_on; ?></p>
                                                                <?php } else { ?>
                                                                    <p class="ms-2 text-dark fs-5 mb-n1"><?php echo $booking['customer_id']; ?></p>
                                                                    <p class="ms-2 text-dark fs-5 mb-n1"><?php echo $booking['name']; ?></p>
                                                                    <p class="ms-2 text-dark fs-5 mb-n1"><?php echo $booking['email']; ?></p>
                                                                    <p class="ms-2 text-dark fs-5 mb-n1"><?php echo '+91' . $booking['phone']; ?></p>
                                                                    <p class="ms-2 text-dark fs-5 mb-n1"><?php echo $booking_pack['name']; ?></p>
                                                                    <p class="ms-2 text-dark fs-5"><?php echo $booking['date']; ?></p>
                                                                <?php }   ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <h4 class="fw-bolder text-dark ps-4 pt-3">Tour Members</h4>
                                            <div class="col-lg-11 col-md-11 col-sm-11 col-11 rounded-5 border border-dark p-3 table-responsive-sm" style="margin: auto;">
                                                <table class="table">
                                                    <thead class="">
                                                        <tr class="py-2 border-bottom border-dark">
                                                            <th class="text-dark fw-bolder">Sr No</th>
                                                            <th class="text-dark fw-bolder">Name</th>
                                                            <th class="text-dark fw-bolder">Gender</th>
                                                            <th class="text-dark fw-bolder">Age</th>
                                                            <th class="text-dark fw-bolder">Member Count</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody class="">
                                                        <?php
                                                        $count_mem = 1;
                                                        foreach ($member as $key => $person) {
                                                            if ($person['gender'] == 'male') {
                                                                $gender = 'Male';
                                                            } else if ($person['gender'] == 'female') {
                                                                $gender = 'Female';
                                                            } else {
                                                                $gender = 'Other';
                                                            }
                                                            echo '<tr class="pt-3">
                                                                        <td class="text-dark fs-5">' . ++$key . '</td>
                                                                        <td class="text-dark fs-5">' . $person['name'] . '</td>
                                                                        <td class="text-dark fs-5">' . $gender . '</td>
                                                                        <td class="text-dark fs-5">' . $person['age'] . '</td>
                                                                        <td class="text-dark fs-5 fw-bolder">';
                                                            if ($count_mem == 1) {
                                                                if ($booking['adults']) {
                                                                    echo '<strong class="count_value" style="font-size: 14px; display:block; padding: 5px;"> ';
                                                                    if ($booking['adults'] > 1) {
                                                                        echo 'Adults ';
                                                                    } else {
                                                                        echo 'Adult ';
                                                                    }
                                                                    echo $booking['adults'] . '</strong>';
                                                                }
                                                                if ($booking['children']) {
                                                                    echo '<strong class="count_value" style="font-size: 14px; display:block; padding: 5px;"> ';
                                                                    if ($booking['children'] > 1) {
                                                                        echo 'Children ';
                                                                    } else {
                                                                        echo 'Child ';
                                                                    }
                                                                    echo $booking['children'] . '</strong>';
                                                                }
                                                                if ($booking['infants']) {
                                                                    echo '<strong class="count_value" style="font-size: 14px; display:block; padding: 5px;"> ';
                                                                    if ($booking['infants'] > 1) {
                                                                        echo 'Infants ';
                                                                    } else {
                                                                        echo 'Infant ';
                                                                    }
                                                                    echo $booking['infants'] . '</strong>';
                                                                }
                                                                $count_mem = 0;
                                                            }
                                                            echo '</td></tr>';
                                                        }
                                                        ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="col-lg-11 col-md-11 col-sm-11 col-11 bg-white mt-4 mb-4 rounded-5 border border-dark" style="margin: auto;">
                                                <div class="row">
                                                    <div class="col-lg-12 col-md-12 col-sm-12 col-12 pt-2">
                                                        <h4 class="text-center text-dark border-bottom border-dark fw-bold pb-2">Amount</h4>
                                                    </div>
                                                    <div class="col-lg-12 col-md-12 col-sm-12 col-12 d-flex pt-3">
                                                        <div class="col-lg-6 col-md-6 col-sm-6 col-6 text-dark ps-3">
                                                            <?php
                                                            // echo '<p class="textColor" style="font-size:11px; padding:5px 2px 5px 10px; color:#473e3e; font-weight:600">Price</p>';
                                                            // if ( $booking['coupons_id'] != "0" ) {
                                                            //     echo '<p class="textColor" style="font-size:11px; padding:5px 2px 5px 10px; color:#473e3e; font-weight:600">Discount</p>';
                                                            //     echo '<hr style="margin: 0px 0px 10px 0px; border-top: 1px solid white;">';
                                                            //     echo '<p class="textColor" style="font-size:11px; padding:5px 2px 5px 10px; color:#473e3e; font-weight:600">Sub Total</p>';
                                                            // }
                                                            // if ( $booking['gst_status'] == "1" ) {
                                                            //     echo '<p class="textColor" style="font-size:11px; padding:5px 2px 5px 10px; color:#473e3e; font-weight:600">GST</p>';
                                                            // }
                                                            echo '<hr style="margin: 0px 0px 10px 0px; border-top: 1px solid white;">';
                                                            echo '<p class="textColor" style="font-size:11px; padding:5px 2px 5px 10px; color:#473e3e; font-weight:600 ">TOTAL</p>';
                                                            ?>
                                                        </div>
                                                        <div class="col-lg-6 col-md-6 col-sm-6 col-6">
                                                            <?php
                                                            if ($booking['gst_status'] == "0") {
                                                                // direct bill
                                                                // echo '<p class="textColor" style="font-size:11px; padding:5px 2px 5px 10px; color:#473e3e;  text-align:right; font-weight:600;">₹ '.$total_direct['total_price'].'</p>';
                                                                if ($booking['coupons_id'] != "0") {
                                                                    // echo '<p class="textColor" style="font-size:11px; padding:5px 2px 5px 10px; color:#473e3e;  text-align:right; font-weight:600;">- ₹ '.$total_direct['coupon_discount'].'</p>';
                                                                    echo '<hr style="margin: 0px 0px 10px 0px; border-top: 1px solid #83a0ae;">';
                                                                    echo '<p class="textColor" style="font-size:11px; padding:5px 2px 5px 10px; color:#473e3e;  text-align:right; font-weight:600;"><strong>₹ ' . $booking_bill['final_price'] . '</strong></p>';
                                                                } else {
                                                                    echo '<hr style="margin: 0px 0px 10px 0px; border-top: 1px solid #83a0ae;">';
                                                                    echo '<p class="textColor" style="font-size:11px; padding:5px 2px 5px 10px; color:#473e3e;  text-align:right; font-weight:600;"><strong>₹ ' . $booking_bill['final_price'] . '</strong></p>';
                                                                }
                                                            } else if ($booking['gst_status'] == "1") {
                                                                // GST Bill
                                                                echo '<p class="textColor" style="font-size:11px; padding:5px 2px 5px 10px; color:#473e3e;  text-align:right; font-weight:600;">₹ ' . number_format((float)$total_gst['total_price'], 2, '.', '') . '</p>';
                                                                if ($booking['coupons_id'] != "0") {
                                                                    echo '<p class="textColor" style="font-size:11px; padding:5px 2px 5px 10px; color:#473e3e;  text-align:right; font-weight:600;">- ₹ ' . number_format((float)$total_gst['coupon_discount'], 2, '.', '') . '</p>';
                                                                    echo '<hr style="margin: 0px 0px 10px 0px; border-top: 1px solid #83a0ae;">';
                                                                    echo '<p class="textColor" style="font-size:11px; padding:5px 2px 5px 10px; color:#473e3e;  text-align:right; font-weight:600;">₹ ' . number_format((float)$booking_bill['final_price'], 2, '.', '') . '</p>';
                                                                }
                                                                echo '<p class="textColor" style="font-size:11px; padding:5px 2px 5px 10px; color:#473e3e;  text-align:right; font-weight:600;"><strong>+ ₹ ' . number_format((float)$total_gst['total_gst'], 2, '.', '') . '</strong></p>';
                                                                echo '<hr style="margin: 0px 0px 10px 0px; border-top: 1px solid #83a0ae;">';
                                                                echo '<p class="textColor" style="font-size:11px; padding:5px 2px 5px 10px; color:#473e3e;  text-align:right; font-weight:600;"><strong>₹ ' . number_format((float)$booking_bill['final_price'], 2, '.', '') . '</strong></p>';
                                                            }
                                                            ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                    <footer>
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-12 p-3">
                                            <ol>
                                                <li class="text-center text-dark fw-bolder" style="font-size: 10px; list-style:none;">304 - 306, Dempo Towers, Patto Plaza Panjim - Goa - 403001</li>
                                            </ol>
                                            <ol class="d-flex justify-content-between contDetails">
                                                <li class="text-dark fw-bolder" style="font-size: 10px; list-style:none;">www.uniqbizz.com</li>
                                                <li class="text-dark fw-bolder" style="font-size: 10px; list-style:none;">support@uniqbizz.com</li>
                                                <li class="text-dark fw-bolder" style="font-size: 10px; list-style:none;">8080785714 / 8010892265</li>
                                            </ol>
                                        </div>
                                    </footer>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> <!-- container-fluid -->
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
    <!--start back-to-top-->
    <button onclick="topFunction()" class="scrollToTop scroll-btn show btn" id="back-to-top">
        <i class="ri-arrow-up-line"></i>
    </button>
    <!--end back-to-top-->

    <!-- JAVASCRIPT -->
    <script src="assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/libs/simplebar/simplebar.min.js"></script>
    <script src="assets/libs/node-waves/waves.min.js"></script>
    <script src="assets/libs/feather-icons/feather.min.js"></script>
    <script src="assets/js/jquery/jquery-3.7.1.min.js"></script>

    <!-- Required datatable js -->
    <script src="assets/libs/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>

    <!-- Responsive examples -->
    <script src="assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
    <script src="assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js"></script>

    <!-- <script src="assets/js/pages/datatables.init.js"></script> -->

    <!-- <script src="assets/js/pages/plugins/lord-icon-2.1.0.js"></script> -->
    <!-- <script src="assets/js/plugins.js"></script> -->

    <!-- !-- materialdesign icon js- -->
    <script src="assets/js/pages/remix-icons-listing.js"></script>

    <!-- apexcharts -->
    <!-- <script src="assets/libs/apexcharts/apexcharts.min.js"></script> -->
    <!--  -->
    <!-- Vector map-->
    <!-- <script src="assets/libs/jsvectormap/js/jsvectormap.min.js"></script> -->
    <!-- <script src="assets/libs/jsvectormap/maps/world-merc.js"></script> -->

    <!--Swiper slider js-->
    <!-- <script src="assets/libs/swiper/swiper-bundle.min.js"></script> -->

    <!-- Dashboard init -->
    <!-- <script src="assets/js/pages/dashboard-ecommerce.init.js"></script> -->

    <!-- App js -->
    <script src="assets/js/app.js"></script>

    <!-- Chart JS -->
    <!-- <script src="assets/libs/chart.js/chart.umd.js"></script>// -->

    <!-- chartjs init -->
    <!-- <script src="assets/js/pages/chartjs.init.js"></script>// -->

    <!-- Dashboard init -->
    <!-- <script src="assets/js/pages/dashboard-job.init.js"></script> -->

    <script>
        $(document).ready(function() {
            $("#example-dataTable").DataTable();
            $("#example-dataTable-2").DataTable();
        });

        function editfunc(id, cut, st, ct, editfor) {
            window.location.href = 'edit_customer.php?vkvbvjfgfikix=' + id + '&ncy=' + cut + '&mst=' + st + '&hct=' + ct + '&editfor=' + editfor;
        };

        function addRefFunc(id, taID, cut, st, ct, editfor) {
            window.location.href = 'add_customer.php?vkvbvjfgfikix=' + id + '&taId=' + taID + '&ncy=' + cut + '&mst=' + st + '&hct=' + ct + '&editfor=' + editfor;
        };

        function deletefunc(id, fid, action) {
            var dataString = 'id=' + id + '&fid=' + fid + '&action=' + action;

            $.ajax({
                type: "POST",
                url: "customer/delete_customer_data.php",
                data: dataString,
                cache: false,
                success: function(data) {
                    console.log(data);
                    if (data == 0) {
                        alert("Deleted Succesfully");
                        window.location.reload();
                    } else if (data == 1) {
                        alert("User Activated Succesfully");
                        window.location.reload();
                    } else if (data == 2) {
                        alert("User Restored Succesfully");
                        window.location.reload();
                    } else if (data == 3) {
                        alert("User Deactivated Succesfully");
                        window.location.reload();
                    } else {
                        alert("Request Failed !!");
                    }
                }
            });
        };

        function confirmfunc(id, email) {
            var dataString = 'id=' + id + '&uname=' + email;

            $.ajax({
                type: "POST",
                url: "customer/confirm_customer.php",
                data: dataString,
                cache: false,
                success: function(data) {
                    if (data == 1) {
                        alert("Email and Password sent via sms and email");
                        window.location.reload();
                    } else {

                        alert("Failed to confirm");
                    }
                }
            });

        };

        function overviewPage(id, ref, cut, st, ct, message) {
            var designation = 'Customer';
            window.location.href = 'overview.php?id=' + id + '&ref=' + ref + '&cut=' + cut + '&st=' + st + '&ct=' + ct + '&message=' + message + '&designation=' + designation;
        }
        $("#generatePDF").on("click", function(e) {
            e.preventDefault(); // Prevent default action

            var divToPrint = document.getElementById("htmlContent");
            if (!divToPrint) {
                alert("Error: Content not found!");
                return;
            }

            var originalContent = document.body.innerHTML; // Store the current page content
            var printContent = divToPrint.innerHTML; // Get only the content inside the div

            // Create a new print section
            var printSection = document.createElement("div");
            printSection.innerHTML = `
                <html>
                    <head>
                        <title>Print Preview</title>
                        <link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
                        <link href="assets/css/custom.min.css" rel="stylesheet" type="text/css" />
                        <link rel="stylesheet" href="assets/fontawesome/css/all.min.css" />
                        <style>
                            @media print {
                                body { margin: 20px; }
                            }
                        </style>
                    </head>
                    <body>
                        ${printContent}
                    </body>
                </html>
            `;

            // Replace body content with printable content
            document.body.innerHTML = printSection.innerHTML;

            // Print and restore content after printing
            window.print();

            // Restore original content after print
            setTimeout(function() {
                document.body.innerHTML = originalContent;
                location.reload(); // Reload page to restore scripts & event listeners
            }, 500);
        });
    </script>
</body>

</html>