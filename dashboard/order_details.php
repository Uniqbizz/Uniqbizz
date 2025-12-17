<?php
include_once 'dashboard_user_details.php';

$id = $_GET['id'];

// Get Booking Data
$bookings = $conn->prepare("SELECT * FROM bookings WHERE id = :id");
$bookings->bindParam(':id', $id, PDO::PARAM_INT);
$bookings->execute();
$booking = $bookings->fetch(PDO::FETCH_ASSOC); // ✅ Use fetch(), not fetchAll()

if (!$booking) {
    die("Booking not found!"); // Handle case where no booking is found
}

// Get Customer
$customers = $conn->prepare("SELECT * FROM ca_customer WHERE ca_customer_id = :cust_id");
$customers->execute([':cust_id' => $booking['customer_id']]);
$customer = $customers->fetch(PDO::FETCH_ASSOC);

// Get Booking Members
$members = $conn->prepare("SELECT * FROM booking_member_details WHERE bookings_id = :bookings_id");
$members->execute([':bookings_id' => $booking['id']]);
$member = $members->fetchAll(PDO::FETCH_ASSOC);

// Format Dates
$booked_on = date('d-M-Y', strtotime($booking['created_date']));
$tour_on = date('d-M-Y', strtotime($booking['date']));


// Get Package
$packages = $conn->prepare("SELECT * FROM package WHERE id = :package_id");
$packages->execute([':package_id' => $booking['package_id']]);
$package = $packages->fetch(PDO::FETCH_ASSOC);

// Get Package Pictures (Only 1 Picture)
$package_pictures = $conn->prepare("SELECT * FROM package_pictures WHERE package_id = :package_id ORDER BY id ASC LIMIT 1");
$package_pictures->execute([':package_id' => $booking['package_id']]);
$pictures = $package_pictures->fetchAll(PDO::FETCH_ASSOC);

// Get GST Bill
$price_gst = $conn->prepare("SELECT * FROM booking_gst_bill WHERE bookings_id = :bookings_id");
$price_gst->execute([':bookings_id' => $booking['id']]);
$total_gst = $price_gst->fetch(PDO::FETCH_ASSOC);

// Get Direct Bill
$price_direct = $conn->prepare("SELECT * FROM booking_direct_bill WHERE bookings_id = :bookings_id");
$price_direct->execute([':bookings_id' => $booking['id']]);
$total_direct = $price_direct->fetch(PDO::FETCH_ASSOC);

// Status
$pay_status = ($total_direct['status'] == '0') ? 'Pending' : 'Successful';
$pay_status_color = ($total_direct['status'] == '0') ? 'orange' : 'green';

// Get Payment Details
$payments = $conn->prepare("SELECT * FROM payment WHERE id = :payment_id");
$payments->execute([':payment_id' => $booking['payment_id']]);
$payment = $payments->fetch(PDO::FETCH_ASSOC);

$count_mem = 1;
// booking date format
$startDate = new DateTime($booking['date']); // Convert to DateTime object

$tourDays = !empty($package['tour_days']) ? (int)$package['tour_days'] : 0; // Ensure it's an integer

$endDate = clone $startDate; // Clone to avoid modifying original date
$endDate->modify("+$tourDays days"); // Add tour days

$today = new DateTime(); // Get the current date
$today->setTime(0, 0); // Reset time for accurate comparison
if ($today > $endDate && $booking['status'] != '2' && $booking['status'] != '3') {
    $book_status = 'Completed';
} else if ($today >= $startDate && $today <= $endDate && $booking['status'] != '2' && $booking['status'] != '3') {
    $book_status = 'In Progress';
}else {
    $book_status = 'Upcoming';
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Order Details</title>
        <!-- App favicon -->
        <link rel="shortcut icon" href="assets/images/fav.png">
        <!-- Bootstrap Css -->
        <link href="assets/css/bootstrap.min.css" id="bootstrap-style" rel="stylesheet" type="text/css" />
        <!-- Icons Css -->
        <link href="assets/css/icons.min.css" rel="stylesheet" type="text/css" />
        <!-- App Css-->
        <link href="assets/css/app.min.css" id="app-style" rel="stylesheet" type="text/css" />
        <!-- custom Css-->
        <link href="assets/css/custom.min.css" rel="stylesheet" type="text/css" />
        <!-- custom Css developer-->
        <link rel="stylesheet" href="assets/css/custom.css" />
        <!-- Font Awesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />

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

            .timeline-with-icons {
                border-left: 1px solid hsl(0, 0%, 90%);
                position: relative;
                list-style: none;
            }

            .timeline-with-icons .timeline-item {
                position: relative;
            }

            .timeline-with-icons .timeline-item:after {
                position: absolute;
                display: block;
                top: 0;
            }

            .timeline-with-icons .timeline-icon {
                position: absolute;
                left: -48px;
                background-color: hsl(217, 88.2%, 90%);
                color: hsl(217, 88.8%, 35.1%);
                border-radius: 50%;
                height: 31px;
                width: 31px;
                display: flex;
                align-items: center;
                justify-content: center;
            }

            .timeline-date {
                display: flex !important;
            }

            .borderAlign {
                border-bottom: 2px solid #919191;
                position: absolute;
                left: 167px;
                width: 130px;
            }

            .borderAlignLeft {
                border-left: 2px solid #919191 !important;
                width: 89px;
                position: absolute;
                height: 90px;
                left: 167px;
                top: -32px;
                border: none;
            }

            .position {
                position: relative;
            }

            .datePara {
                width: 125px !important;
            }
            /* New design style */
            .text-decoration {
                border: none; 
                height: 1px;
                border-top: 1px dashed #000;
            }
            
        </style>
    </head>
    <body data-sidebar="dark">
        <div class="layout-wrapper">
            <?php
            // top header logo, hamberger menu, fullscreen icon, profile
            include_once 'header.php';

            // sidebar navigation menu 
            include_once 'sidebar.php';
            ?>
            <div class="layout-wrapper">
                <div class="main-content">
                    <div class="page-content">
                        <div class="container-fluid">
                            <div class="text-end p-3">
                                <!-- return previous page link -->
                                <li class=" badge badge-pill p-2" id="return_to_views_btn" style="width:fit-content; background-color: #0036a2"><a href="order_history.php" class="text-white"><i class="fa fa-backward text-white" aria-hidden="true"></i> Back</a></li>
                            </div>
                            <div class="row">
                                <div class="card">
                                    <div class="col-lg-12 col-md-12 col-sm-12 d-flex justify-content-between pb-3 pt-3 mb-4" style="border-bottom: 1px solid #DDDDDD">
                                        <h5 class="fw-bold fs-3">Order Details</h5>
                                        <button id="generatePDF" class="bg-success text-white rounded-3 border-0 p-2" href="">
                                            <i class="mdi mdi-download font-size-16 text-white me-1"></i>
                                            Download Invoice
                                        </button>
                                    </div>
                                    <div class="row d-flex justify-content-center" id="htmlContent">
                                        <div class="row px-2 pb-2 mb-3 rounded-5 border border-dark" style="width:700px;">
                                            <div class="col-lg-12 col-md-12 col-sm-12">
                                                <div class="row">
                                                    <div class="col-lg-12 col-md-12 col-sm-12 p-3 d-flex justify-content-between pt-5">
                                                        <!-- <img src="assets/images/uniqbizz_logo.png" alt="uniqbizz logo" height="20px;" class="mt-4"> -->
                                                        <img src="assets/images/bizz_logo.png" alt="uniqbizz logo" height="50px" width="100px">
                                                        <div>
                                                            <p class="fw-bold pt-3 mb-0">Invoice No: <span class="fw-normal"> <?php echo $booking['invoice_no'] ?></span></p>
                                                            <p class="fw-bold pt-0 mb-0 text-end">Date: <span class="fw-normal"><?php echo $booked_on ?></span></p>
                                                        </div>
                                                    </div>
                                                    <hr class="text-decoration"></hr>
                                                </div>
                                            </div>
                                            <div class="col-lg-12 col-md-12 col-sm-12">
                                                <div class="row">
                                                    <div class="col-lg-12 col-md-12 col-sm-12 p-3 d-flex justify-content-between pt-0">
                                                        <div>
                                                            <p class="fw-bold pt-2 mb-0">Invoice To: </p>
                                                            <p class="mb-0"><?php echo $booking['name']; ?></p>
                                                            <p class="mb-0"><?php echo $booking['email']; ?></p>
                                                            <p class="mb-0"><?php echo $booking['phone']; ?></p>
                                                            <p class="mb-0"><?php echo $customer['address']; ?></p>
                                                            <p class="mb-0">Customer ID: <span class=""><?php echo $booking['customer_id']; ?></span></p>
                                                        </div>
                                                        <div>
                                                            <p class="fw-bold pt-2 mb-0 text-end">BizzMirth Holidays Pvt Ltd :</p>
                                                            <p class="mb-0 text-end">304 - 306, dempo Towers, Patto Plaza Panaji - Goa. 403001</p>
                                                            <p class="mb-0 text-end">support@uniqbizz.com</p>
                                                            <p class="mb-0 text-end">8010892265</p>
                                                        </div>
                                                    </div>
                                                    <hr class="text-decoration"></hr>
                                                </div>
                                            </div>
                                            <div class="col-lg-12 col-md-12 col-sm-12">
                                                <div class="row">
                                                    <div class="col-lg-12 col-md-12 col-sm-12 col-12 pt-0" style="padding-left: 35px">
                                                        <!-- <h5 style="color: #000; font-size: bolder">Invoice No. <strong> <?php echo $booking['invoice_no'] ?></strong></h5> -->
                                                        <p class="fw-bolder mb-0">Booking No: <span class="fw-normal"><?php echo $booking['order_id'] ?></span></p>
                                                        <p class="fw-bolder mb-0">Payment: <span style="color:<?= $pay_status_color ?>"><?php echo $pay_status; ?></span></p>
                                                        <p class="fw-bolder"> Transaction ID:
                                                            <span class="fs-6 fw-normal"><?php echo $total_direct['paymentid'] ?></span>
                                                        </p>
                                                    </div>
                                                    <!-- <div class="col-lg-6 col-md-6 col-sm-6 col-6 text-end pt-3" style="padding-right: 42px">
                                                        <h5 style="color: #000; font-size: bolder">₹ <strong> <?php echo number_format((float)$total_direct['total_price'], 2, '.', '') ?></strong></h5>
                                                        <?php
                                                        // if ($booking['gst_status'] == "1") {
                                                        //     echo '<p class="textColor" style="text-align: right; padding:5px 0px; color:#473e3e; ">GSTIN - ' . $total_direct['gst_number'] . '</p>';
                                                        // }
                                                        ?>
                                                    </div> -->
                                                    <div class="col-lg-11 col-md-11 col-sm-11 col-11 rounded-5 border border-dark" style="margin: auto;">
                                                        <div class="row">
                                                            <div class="col-lg-12 col-md-12 col-sm-12 col-12 p-3 pb-1">
                                                                <?php
                                                                foreach ($pictures as $key => $picture) {
                                                                    echo '<div class="preview-images-zone qrCode" style="height:180px; width:100%; border-radius: 20px; position:relative; margin-right:1px; display:inline-flex;">
                                                                                <img src="../' . $picture['image'] . '" style="width: 100%; height: 180px; border-radius: 20px; object-fit: cover;">
                                                                            </div>
                                                                            ';
                                                                }
                                                                ?>
                                                            </div>
                                                            <div class="col-lg-12 col-md-12 col-sm-12 col-12 pt-0">
                                                                
                                                                <p class="ms-3 text-dark fs-6 mb-0 fw-bolder">Order ID: <span class="fw-normal"><?php echo $booking['order_id']; ?></span></p>
                                                                <p class="ms-3 text-dark fs-6 mb-0 fw-bolder">Package: <span class="fw-normal"><?php echo $package['name']; ?></span></p>
                                                                <p class="ms-3 text-dark fs-6 mb-0 fw-bolder">Destination: <span class="fw-normal"></span></p>
                                                                <p class="ms-3 text-dark fs-6 mb-0 fw-bolder">Departure Date: <span class="fw-normal"><?php echo $tour_on; ?></span></p>
                                                                <p class="ms-3 text-dark fs-6 fw-bolder">Member Count: <span class="fw-normal"><?php echo "Adults-".$booking['adults']  .", Child-".$booking['children'] .", Infants-".$booking['infants']; ?></span></p>
                                                                    
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <h5 class="fw-bolder text-dark ps-4 pt-3 ms-2">Tour Members</h5>
                                                <div class="col-lg-11 col-md-11 col-sm-11 col-11 rounded-5 border border-dark px-4 py-2 table-responsive-sm" style="margin: auto;">
                                                    <table class="table">
                                                        <thead class="">
                                                            <tr class="py-2 border-bottom border-dark">
                                                                <th class="text-dark fw-bolder">Sr No</th>
                                                                <th class="text-dark fw-bolder">Name</th>
                                                                <th class="text-dark fw-bolder">Gender</th>
                                                                <th class="text-dark fw-bolder">Age</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody class="">
                                                            <?php

                                                            foreach ($member as $key => $person) {
                                                                if ($person['gender'] == 'male') {
                                                                    $gender = 'Male';
                                                                } else if ($person['gender'] == 'female') {
                                                                    $gender = 'Female';
                                                                } else {
                                                                    $gender = 'Other';
                                                                }
                                                                echo '<tr class="pt-3">
                                                                            <td class="text-dark">' . ++$key . '</td>
                                                                            <td class="text-dark">' . $person['name'] . '</td>
                                                                            <td class="text-dark">' . $gender . '</td>
                                                                            <td class="text-dark">' . $person['age'] . '</td>
                                                                            <td class="text-dark fw-bolder">';

                                                                echo '</td></tr>';
                                                            }
                                                            ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <div class="col-lg-11 col-md-12 col-sm-12" style="margin: auto;">
                                                    <div class="row">
                                                        <div class="col-lg-12 col-md-12 col-sm-12 p-3 d-flex justify-content-between">
                                                            <div>
                                                                <h5 class="fw-bolder text-dark">Thank You For Your Business</h5>
                                                            </div>
                                                            <div>
                                                                <p class="fw-bold mb-0 text-end">Sub Total: <span class="fw-normal"> <?php echo $total_direct['final_price'] ?></span></p>
                                                                <!-- only if coupon is applied -->
                                                                <?php
                                                                    if($booking['coupons_code'] != ""){

                                                                ?>
                                                                <p class="fw-bold pt-0 mb-0 text-end">Coupon Applied: <span class="fw-normal" style="coupon-position"><?= $total_direct['coupon_discount']?></span></p>
                                                                <p class="fw-bold pt-0 mt-n1 ms-n4 mb-0 text-start">(<span><?php echo $booking['coupons_code'] ?></span>)</p>
                                                                <?php
                                                                    } 
                                                                    //if GST is applicable
                                                                    if ($booking['gst_status'] == "1") {
                                                                ?>
                                                                    <p class="fw-bold pt-0 mb-0 text-end">GST: <span class="fw-normal"><?= number_format((float)$total_gst['total_gst'], 2, '.', '')?></span></p>
                                                                <?php
                                                                    }
                                                                ?>
                                                                <hr class="text-decoration my-0"></hr>
                                                                <p class="fw-bold mb-0 mt-1 text-end">Total: <span class="fw-normal"> <?php echo  $total_direct['total_price'] ?></span></p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- <div class="col-lg-11 col-md-11 col-sm-11 col-11 bg-white mt-4 mb-4 rounded-5 border border-dark" style="margin: auto;">
                                                    <div class="row">
                                                        <div class="col-lg-12 col-md-12 col-sm-12 col-12 pt-2">
                                                            <h5 class="text-center text-dark border-bottom border-dark fw-bold pb-2">Amount</h5>
                                                        </div>
                                                        <div class="col-lg-12 col-md-12 col-sm-12 col-12 d-flex pt-3">
                                                            <div class="col-lg-6 col-md-6 col-sm-6 col-6 text-dark ps-3"> -->
                                                                <?php
                                                                // echo '<p class="textColor mb-0" style="font-size:11px; padding:0px 2px 0px 10px; color:#473e3e; font-weight:600">Price:</p>';
                                                                // if ($booking['coupons_code'] != "") {
                                                                //     echo '<p class="textColor mb-0" style="font-size:11px; padding:0px 2px 0px 10px; color:#473e3e; font-weight:600">Coupon Applied:</p>';
                                                                //     echo '<p class="textColor mt-0" style="font-size:11px; padding:0px 2px 0px 10px; color:#473e3e; font-weight: bold;"><strong>' . $booking['coupons_code'] . '</strong></p>';
                                                                // }
                                                                // if ($booking['gst_status'] == "1") {
                                                                //     echo '<p class="textColor mt-0" style="font-size:11px; padding:0px 2px 0px 10px; color:#473e3e; font-weight:600">GST</p>';
                                                                // }
                                                                // echo '<hr style="margin: 0px 0px 10px 0px; border-top: 1px solid white;">';
                                                                // echo '<p class="textColor" style="font-size:11px; padding:5px 2px 5px 10px; color:#473e3e; font-weight:600 ">TOTAL</p>';
                                                                ?>
                                                            <!-- </div>
                                                            <div class="col-lg-6 col-md-6 col-sm-6 col-6"> -->
                                                                <?php
                                                                // if ($booking['gst_status'] == "0") {
                                                                //     // direct bill
                                                                //     echo '<p class="textColor mb-0" style="font-size:11px; padding:0px 2px 0px 10px; color:#473e3e;  text-align:left; font-weight:600;">₹ ' . $total_direct['final_price'] . '</p>';
                                                                //     if ($booking['coupons_code'] != "") {

                                                                //         echo '<p class="textColor" style="font-size:11px; padding:5px 2px 5px 10px; color:#473e3e;  text-align:left; font-weight:600;">- ₹ ' . $total_direct['coupon_discount'] . '</p>';
                                                                //         echo '<hr style="margin: 0px 0px 10px 0px; border-top: 1px solid #83a0ae;">';
                                                                //         echo '<p class="textColor" style="font-size:18px; padding:5px 2px 5px 10px; color:#473e3e;  text-align:left; font-weight:600;"><strong>₹ ' . $total_direct['total_net_payable'] . '</strong></p>';
                                                                //     } else {
                                                                //         echo '<hr style="margin: 0px 0px 10px 0px; border-top: 1px solid #83a0ae;">';
                                                                //         echo '<p class="textColor" style="font-size:18px; padding:5px 2px 5px 10px; color:#473e3e;  text-align:left; font-weight:600;"><strong>₹ ' . $total_direct['total_price'] . '</strong></p>';
                                                                //     }
                                                                // } else if ($booking['gst_status'] == "1") {
                                                                //     // GST Bill
                                                                //     echo '<p class="textColor" style="font-size:11px; padding:5px 2px 5px 10px; color:#473e3e;  text-align:left; font-weight:600;">₹ ' . number_format((float)$total_gst['total_price'], 2, '.', '') . '</p>';
                                                                //     if ($booking['coupons_code'] != "") {

                                                                //         echo '<p class="textColor" style="font-size:11px; padding:5px 2px 5px 10px; color:#473e3e;  text-align:left; font-weight:600;">- ₹ ' . number_format((float)$total_gst['coupon_discount'], 2, '.', '') . '</p>';
                                                                //         echo '<hr style="margin: 0px 0px 10px 0px; border-top: 1px solid #83a0ae;">';
                                                                //         echo '<p class="textColor" style="font-size:11px; padding:5px 2px 5px 10px; color:#473e3e;  text-align:left; font-weight:600;">₹ ' . number_format((float)$total_gst['net_payable'], 2, '.', '') . '</p>';
                                                                //     }
                                                                //     echo '<p class="textColor" style="font-size:11px; padding:5px 2px 5px 10px; color:#473e3e;  text-align:left; font-weight:600;"><strong>+ ₹ ' . number_format((float)$total_gst['total_gst'], 2, '.', '') . '</strong></p>';
                                                                //     echo '<hr style="margin: 0px 0px 10px 0px; border-top: 1px solid #83a0ae;">';
                                                                //     echo '<p class="textColor" style="font-size:14px; padding:5px 2px 5px 10px; color:#473e3e;  text-align:left; font-weight:600;"><strong>₹ ' . number_format((float)$total_gst['total_net_payable'], 2, '.', '') . '</strong></p>';
                                                                // }
                                                                ?>
                                                            <!-- </div>
                                                        </div>
                                                    </div>
                                                </div> -->
                                                <!-- </div> -->
                                            </div>
                                            <footer>
                                                <div class="col-lg-12 col-md-12 col-sm-12 col-12 p-3">
                                                    <ol>
                                                        <li class="text-center text-dark fw-bolder" style="font-size: 10px; list-style:none;">This invoice is computer-generated.</li>
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
                            <!-- Active Logs Start -->
                            <div class="row" style="padding-left: 12px; padding-right: 12px;">
                                <div class="card">
                                    <div class="col-md-8">
                                        <div class="d-flex align-items-center p-3 position">
                                            <p class="d-inline datePara"><?= (new DateTime($booking['created_date']))->format('d/m/Y H:i') ?></p>
                                            <p class="rounded-circle ms-2 bg-primary p-1 mb-0">
                                                <i class="fa-regular fa-calendar-check fa-xl d-flex align-items-center justify-content-center" style="color: #ffffff; width: 30px; height: 30px;"></i>
                                            </p>
                                            <hr>
                                            <h4 class="ms-2">Booked</h4>
                                        </div>
                                    </div>
                                    <div class="col-md-10">
                                        <div class="d-flex justify-content-end position">
                                            <hr class="borderAlign">
                                            <hr class="borderAlignLeft">
                                            <div class="card bg-light p-2 w-75">
                                                <p class="mb-0 cardText"><span class="fw-bold"><?= $booking['name'] ?></span> has <span class="fw-bold">Booked</span> the package for <span class="fw-bold"><?= $package['name'] ?></span> with <span class="fw-bold">Booking ID: <?= $booking['order_id'] ?></span></p>
                                            </div>
                                        </div>
                                    </div>
                                    <?php if ($total_direct['pay_type'] == 1) { ?>
                                        <div class="col-md-8">
                                            <div class="d-flex align-items-center p-3 pt-0 position">
                                                <p class="d-inline datePara"><?= (new DateTime($total_direct['created_at']))->format('d/m/Y H:i') ?></p>
                                                <p class="rounded-circle ms-2 bg-primary p-1 mb-0">
                                                    <i class="fa-solid fa-money-bill fa-xl d-flex align-items-center justify-content-center" style="color: #ffffff; width: 30px; height: 30px;"></i>
                                                </p>
                                                <hr>
                                                <h4 class="ms-2">Full Payment</h4>
                                            </div>
                                        </div>
                                        <div class="col-md-10">
                                            <div class="d-flex justify-content-end position">
                                                <hr class="borderAlign">
                                                <hr class="borderAlignLeft">
                                                <div class="card bg-light p-2 w-75">
                                                    <p class="mb-0 cardText"><span class="fw-bold"><?= $booking['name'] ?></span> has <span class="fw-bold">Payed <?= $total_direct['amount'] ?></span> for the package <span class="fw-bold"><?= $package['name'] ?></span> with <span class="fw-bold">Booking ID: <?= $booking['order_id'] ?></span></p>
                                                </div>
                                            </div>
                                        </div>
                                    <?php } else if ($total_direct['pay_type'] == 2) { ?>
                                        <div class="col-md-8">
                                            <div class="d-flex align-items-center p-3 pt-0 position">
                                                <p class="d-inline datePara"><?= (new DateTime($total_direct['created_at']))->format('d/m/Y H:i') ?></p>
                                                <p class="rounded-circle ms-2 bg-primary p-1 mb-0">
                                                    <i class="fa-solid fa-money-bill fa-xl d-flex align-items-center justify-content-center" style="color: #ffffff; width: 30px; height: 30px;"></i>
                                                </p>
                                                <hr>
                                                <h4 class="ms-2">Part Payment</h4>
                                            </div>
                                        </div>
                                        <div class="col-md-10">
                                            <div class="d-flex justify-content-end position">
                                                <hr class="borderAlign">
                                                <hr class="borderAlignLeft">
                                                <div class="card bg-light p-2 w-75">
                                                    <p class="mb-0 cardText"><span class="fw-bold"><?= $booking['name'] ?></span> has <span class="fw-bold">done first part payment of Rs.<?= $total_direct['part_pay_1'] ?> and pending second part payment</span> for the package of <span class="fw-bold"><?= $package['name'] ?></span> with <span class="fw-bold">Booking ID: <?= $booking['order_id'] ?></span></p>
                                                </div>
                                            </div>
                                            <?php if ($total_direct['part_pay_2_status'] == 1) { ?>
                                                <div class="d-flex justify-content-end position">
                                                    <hr class="borderAlign">
                                                    <hr class="borderAlignLeft">
                                                    <div class="card bg-light p-2 w-75">
                                                        <p class="mb-0 cardText"><span class="fw-bold"><?= $booking['name'] ?></span> has <span class="fw-bold">done second part payment of Rs.<?= $total_direct['part_pay_2'] ?></span> for the package of <span class="fw-bold"><?= $package['name'] ?></span> with <span class="fw-bold">Booking ID: <?= $booking['order_id'] ?></span></p>
                                                    </div>
                                                </div>
                                            <?php } ?>
                                        </div>
                                    <?php } else if ($total_direct['pay_type'] == 3) { ?>
                                        <div class="col-md-8">
                                            <div class="d-flex align-items-center p-3 pt-0 position">
                                                <p class="d-inline datePara"><?= (new DateTime($total_direct['created_at']))->format('d/m/Y H:i') ?></p>
                                                <p class="rounded-circle ms-2 bg-primary p-1 mb-0">
                                                    <i class="fa-solid fa-money-bill fa-xl d-flex align-items-center justify-content-center" style="color: #ffffff; width: 30px; height: 30px;"></i>
                                                </p>
                                                <hr>
                                                <h4 class="ms-2">Part Payment</h4>
                                            </div>
                                        </div>
                                        <div class="col-md-10">
                                            <div class="d-flex justify-content-end position">
                                                <hr class="borderAlign">
                                                <hr class="borderAlignLeft">
                                                <div class="card bg-light p-2 w-75">
                                                    <p class="mb-0 cardText"><span class="fw-bold"><?= $booking['name'] ?></span> has <span class="fw-bold">completed the first payment of Rs.<?= $total_direct['part_pay_1'] ?> </span> for the <span class="fw-bold"><?= $package['name'] ?></span> package <span class="fw-bold">(Booking ID: <?= $booking['order_id'] ?>)</span> second and third payments are pending.</p>
                                                </div>
                                            </div>

                                            <?php if ($total_direct['part_pay_2_status'] == 1) { ?>
                                                <div class="d-flex justify-content-end position">
                                                    <hr class="borderAlign">
                                                    <hr class="borderAlignLeft">
                                                    <div class="card bg-light p-2 w-75">
                                                        <p class="mb-0 cardText"><span class="fw-bold"><?= $booking['name'] ?></span> has <span class="fw-bold">completed the second payment of Rs.<?= $total_direct['part_pay_1'] ?> </span> for the <span class="fw-bold"><?= $package['name'] ?></span> package <span class="fw-bold">(Booking ID: <?= $booking['order_id'] ?>)</span> third payment is pending.</p>
                                                    </div>
                                                </div>
                                            <?php } ?>
                                            <?php if ($total_direct['part_pay_3_status'] == 1) { ?>
                                                <div class="d-flex justify-content-end position">
                                                    <hr class="borderAlign">
                                                    <hr class="borderAlignLeft">
                                                    <div class="card bg-light p-2 w-75">
                                                        <p class="mb-0 cardText"><span class="fw-bold"><?= $booking['name'] ?></span> has <span class="fw-bold">completed the third payment of Rs.<?= $total_direct['part_pay_1'] ?> </span> for the <span class="fw-bold"><?= $package['name'] ?></span> package <span class="fw-bold">(Booking ID: <?= $booking['order_id'] ?>)</span></p>
                                                    </div>
                                                </div>
                                            <?php } ?>
                                        </div>
                                    <?php }
                                    if ($book_status == 'Completed') { ?>

                                        <div class="col-md-8">
                                            <div class="d-flex align-items-center p-3 pt-0 position">
                                                <p class="d-inline datePara"><?= $endDate->format('d/m/Y H:i') ?></p>
                                                <p class="rounded-circle ms-2 bg-primary p-1 mb-0">
                                                    <i class="fa-brands fa-fly fa-xl d-flex align-items-center justify-content-center" style="color: #ffffff; width: 30px; height: 30px;"></i>
                                                </p>
                                                <hr>
                                                <h4 class="ms-2">Completed</h4>
                                            </div>
                                        </div>
                                        <div class="col-md-10">
                                            <div class="d-flex justify-content-end position">
                                                <hr class="borderAlign">
                                                <hr class="borderAlignLeft">
                                                <div class="card bg-light p-2 w-75">
                                                    <p class="mb-0 cardText"><span class="fw-bold"><?= $booking['name'] ?></span> has <span class="fw-bold">Completed</span> the tour for <span class="fw-bold"><?= $package['name'] ?></span> package <span class="fw-bold">(Booking ID: <?= $booking['order_id'] ?>)</span></p>
                                                </div>
                                            </div>
                                        </div>
                                    <?php }
                                    if ($booking['status'] == '2' || $booking['cancel_date'] !=NULL) { ?>
                                        <div class="col-md-8">
                                            <div class="d-flex align-items-center p-3 pt-0 position">
                                                <p class="d-inline datePara"><?= $booking['cancel_date'] ?></p>
                                                <p class="rounded-circle ms-2 bg-primary p-1 mb-0">
                                                    <i class="fa-solid fa-trash-can fa-xl d-flex align-items-center justify-content-center" style="color: #ffffff; width: 30px; height: 30px;"></i>
                                                </p>
                                                <hr>
                                                <h4 class="ms-2">Canceled</h4>
                                            </div>
                                        </div>
                                        <div class="col-md-10">
                                            <div class="d-flex justify-content-end position">
                                                <hr class="borderAlign">
                                                <hr class="borderAlignLeft">
                                                <div class="card bg-light p-2 w-75">
                                                    <p class="mb-0 cardText"><span class="fw-bold"><?= $booking['name'] ?></span> has <span class="fw-bold">Canceled</span> the tour for <span class="fw-bold"><?= $package['name'] ?></span> package <span class="fw-bold">(Booking ID: <?= $booking['order_id'] ?>)</p>
                                                </div>
                                            </div>
                                        </div>
                                    <?php }
                                    if ($booking['status'] == '3' || $booking['refund_date']) {?>
                                        <div class="col-md-8">
                                            <div class="d-flex align-items-center p-3 pt-0 position">
                                                <p class="d-inline datePara"><?= $booking['refund_date'] ?></p><!--get the refund date-->
                                                <p class="rounded-circle ms-2 bg-primary p-1 mb-0">
                                                    <i class="fa-solid fa-money-bill-transfer fa-xl d-flex align-items-center justify-content-center" style="color: #ffffff; width: 30px; height: 30px;"></i>
                                                </p>
                                                <hr>
                                                <h4 class="ms-2">Refunded</h4>
                                            </div>
                                        </div>
                                        <div class="col-md-10">
                                            <div class="d-flex justify-content-end position">
                                                <hr class="borderAlign">
                                                <hr class="borderAlignLeft">
                                                <div class="card bg-light p-2 w-75">
                                                    <p class="mb-0 cardText"><span class="fw-bold"><?= $booking['name'] ?></span> has <span class="fw-bold">Refunded amount of Rs.<?=$booking['refund_amt']?></span> for the <span class="fw-bold"><?= $package['name'] ?></span> package <span class="fw-bold">(Booking ID: <?= $booking['order_id'] ?>)</p>
                                                </div>
                                            </div>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                            <!-- Active Logs End -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- JAVASCRIPT -->
        <script src="assets/libs/jquery/jquery.min.js"></script>
        <script src="assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
        <script src="assets/libs/metismenu/metisMenu.min.js"></script>
        <script src="assets/libs/simplebar/simplebar.min.js"></script>
        <script src="assets/libs/node-waves/waves.min.js"></script>

        <!-- App js -->
        <script src="assets/js/app.js"></script>
        <script>
            $("#generatePDF").click(function() {
                // $(document).ready(function() {
                var divToPrint = document.getElementById('htmlContent');
                newWin = window.open("");
                newWin.document.write('<html><head><link rel="stylesheet" href="assets/css/bootstrap.min.css"><link rel="stylesheet" href="../assets/css/icons.min.css"><link rel="stylesheet" href="../assets/css/app.min.css"></head><body onload="window.print()">' + divToPrint.outerHTML + '</body></html>');
                newWin.print();
                newWin.close();

                // reoad back to history page
                window.history.back();
            });
        </script>
    </body>
</html>