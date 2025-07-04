<?php
include_once 'dashboard_user_details.php';

?>
<!doctype html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg" data-sidebar-image="none" data-preloader="disable">

<head>
    <meta charset="utf-8" />
    <title>Admin Dashboard | Tour History</title>
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
                                <h4 class="mb-sm-0">View Tour History</h4>

                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
                                        <li class="breadcrumb-item active">View Tour History </li>
                                    </ol>
                                </div>

                            </div>
                        </div>
                    </div>
                    <!-- end page title -->

                    <div class="row">
                        <div class="col">

                            <div class="h-100">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="card">
                                            <div class="card-header border-bottom-dashed">
                                                <div class="row g-4 align-items-center">
                                                    <!-- <div class="col-sm">
                                                            <div>
                                                                <h5 class="card-title mb-0">Pending List</h5>
                                                            </div>
                                                        </div> -->
                                                    <!-- <?php if ($userType == "10" || $userType == "11" || $userType == "16") { ?>
                                                            <div class="col-sm-auto">
                                                                <a href="add_customer.php">
                                                                    <button type="button" class="btn btn-success " data-bs-toggle="modal" id="create-btn" data-bs-target="#showModal">
                                                                        <i class="ri-add-line align-bottom me-1"></i>Add Customer
                                                                    </button>
                                                                </a>
                                                            </div>
                                                        <?php } ?> -->
                                                </div>
                                            </div>

                                            <div class="card-body">
                                                <table id="example-dataTable" class="table table-bordered dt-responsive nowrap table-striped align-middle" style="width:100%">
                                                    <thead>
                                                        <tr>
                                                            <th>SR No.</th>
                                                            <th>Booking Id</th>
                                                            <th>Tour Date</th>
                                                            <th>Package Name</th>
                                                            <?php if ($userType == "16") {
                                                                echo '<th>Travel Consultant</th>';
                                                            }
                                                            ?>
                                                            <th>Customer</th>
                                                            <th>Payment</th>
                                                            <th>Status</th>
                                                            <th>Action</th>

                                                            <!-- -->
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        if ($userType == "11" || $userType == "10" || $userType == '16') {
                                                            if ($userType == "11") {
                                                                $sql = "
                                                                SELECT b.id,
                                                                    b.order_id, 
                                                                    b.customer_id, 
                                                                    b.package_id, 
                                                                    p.name AS package_name,
                                                                    p.tour_days,
                                                                    b.name AS c_name,
                                                                    b.phone,
                                                                    b.email,
                                                                    b.date,
                                                                    b.status
                                                                FROM bookings b
                                                                JOIN package p ON b.package_id = p.id
                                                                WHERE b.ta_id ='" . $userId . "'
                                                            ";
                                                            } else if ($userType == "10") {
                                                                $sql = "
                                                                SELECT b.id,
                                                                    b.order_id, 
                                                                    b.customer_id, 
                                                                    b.package_id, 
                                                                    p.name AS package_name,
                                                                    p.tour_days,
                                                                    b.name AS c_name,
                                                                    b.phone,
                                                                    b.email,
                                                                    b.date,
                                                                    b.status
                                                                FROM bookings b
                                                                JOIN package p ON b.package_id = p.id
                                                                WHERE b.customer_id ='" . $userId . "'
                                                            ";
                                                            } else if ($userType == "16") {
                                                                $sql0 = "SELECT ca_travelagency_id, firstname, lastname, email, contact_no FROM ca_travelagency WHERE reference_no = :userId";
                                                                $stmt0 = $conn->prepare($sql0);
                                                                $stmt0->bindParam(':userId', $userId, PDO::PARAM_INT);
                                                                $stmt0->execute();
                                                                $ta_list = $stmt0->fetchAll(PDO::FETCH_ASSOC); // Fetch as associative array

                                                                // Create an array mapping travel agency IDs to their details
                                                                $ta_details = [];
                                                                $ta_ids = [];

                                                                foreach ($ta_list as $ta) {
                                                                    $ta_ids[] = $ta['ca_travelagency_id']; // Collecting IDs for SQL query
                                                                    $ta_details[$ta['ca_travelagency_id']] = [
                                                                        'firstname' => $ta['firstname'],
                                                                        'lastname' => $ta['lastname'],
                                                                        'email' => $ta['email'],
                                                                        'phone' => $ta['contact_no']
                                                                    ];
                                                                }

                                                                if (!empty($ta_list)) {
                                                                    $ta_ids_str = "'" . implode("','", $ta_ids) . "'"; // Convert array to comma-separated string
                                                                    $sql = "
                                                                        SELECT b.id,
                                                                               b.order_id, 
                                                                               b.customer_id, 
                                                                               b.package_id, 
                                                                               p.name AS package_name,
                                                                               p.tour_days,
                                                                               b.name AS c_name,
                                                                               b.phone,
                                                                               b.email,
                                                                               b.date,
                                                                               b.ta_id,
                                                                               b.status
                                                                        FROM bookings b
                                                                        JOIN package p ON b.package_id = p.id
                                                                        WHERE b.ta_id IN ($ta_ids_str)"; // Use IN clause to match multiple IDs
                                                                }
                                                            }

                                                            $stmt = $conn->prepare($sql);
                                                            $stmt->execute();
                                                            $bookings = $stmt->fetchAll(PDO::FETCH_ASSOC);


                                                            // print_r($stmt);
                                                            $i = 0;
                                                            foreach ($bookings as $booking) {
                                                                $sql3 = "SELECT * FROM booking_direct_bill WHERE bookings_id = " . $booking['id'] . "";
                                                                $stmt3 = $conn->prepare($sql3);
                                                                $stmt3->execute();
                                                                $booking_bill = $stmt3->fetch(PDO::FETCH_ASSOC);
                                                                $formattedDate = date("d-m-Y", strtotime($booking['date']));
                                                                echo '<tr>
                                                                        <td>' . ++$i . '</td>
                                                                        <td>' . $booking['order_id'] . '</td>
                                                                        <td>' . $formattedDate . '</td>
                                                                        <td>' . $booking['package_name'] . '</td>
                                                                        <td>' . $booking['c_name'] . '(' . $booking['customer_id'] . ')<br>
                                                                        ' . $booking['phone'] . '<br>' . $booking['email'] . '</td>';
                                                                if ($userType == "16") {
                                                                    $ta_id = $booking['ta_id']; // Get the agency ID from booking

                                                                    // Retrieve travel agency details safely
                                                                    $agency_info = isset($ta_details[$ta_id]) ? $ta_details[$ta_id] : ['firstname' => '', 'lastname' => '', 'email' => '', 'phone' => ''];

                                                                    echo '<td>' . $agency_info['firstname'] . ' ' . $agency_info['lastname'] . '<br>
                                                                                ' . $agency_info['phone'] . '<br>' . $agency_info['email'] . '</td>';
                                                                }
                                                                if ($booking_bill['pay_type'] == 2) {
                                                                    # code...
                                                                    if ($booking_bill['part_pay_1_status'] == 1 && $booking_bill['part_pay_2_status'] == 0) {
                                                                        # code...
                                                                        $perecent_fill = 50;
                                                                        $booking_paid_amt = $booking_bill['part_pay_1'];
                                                                        $booking_full_amt = $booking_bill['final_price'];
                                                                    } elseif ($booking_bill['part_pay_1_status'] == 1 && $booking_bill['part_pay_2_status'] == 1) {
                                                                        # code...
                                                                        $perecent_fill = 100;
                                                                        $booking_paid_amt = $booking_bill['part_pay_1'] + $booking_bill['part_pay_2'];
                                                                        $booking_full_amt = $booking_bill['final_price'];
                                                                    }
                                                                } else if ($booking_bill['pay_type'] == 3) {
                                                                    # code...
                                                                    if ($booking_bill['part_pay_1_status'] == 1 && $booking_bill['part_pay_2_status'] == 0 && $booking_bill['part_pay_3_status'] == 0) {
                                                                        # code...
                                                                        $perecent_fill = 40;
                                                                        $booking_paid_amt = $booking_bill['part_pay_1'];
                                                                        $booking_full_amt = $booking_bill['final_price'];
                                                                    } elseif ($booking_bill['part_pay_1_status'] == 1 && $booking_bill['part_pay_2_status'] == 1 && $booking_bill['part_pay_3_status'] == 0) {
                                                                        # code...
                                                                        $perecent_fill = 70;
                                                                        $booking_paid_amt = $booking_bill['part_pay_1'] + $booking_bill['part_pay_2'];
                                                                        $booking_full_amt = $booking_bill['final_price'];
                                                                    } elseif ($booking_bill['part_pay_1_status'] == 1 && $booking_bill['part_pay_1_status'] == 1 && $booking_bill['part_pay_3_status'] == 1) {
                                                                        # code...
                                                                        $perecent_fill = 100;
                                                                        $booking_paid_amt = $booking_bill['part_pay_1'] + $booking_bill['part_pay_2'] + $booking_bill['part_pay_3'];
                                                                        $booking_full_amt = $booking_bill['final_price'];
                                                                    }
                                                                } else {
                                                                    $perecent_fill = 100;
                                                                    $booking_paid_amt = $booking_bill['amount'];
                                                                    $booking_full_amt = $booking_bill['final_price'];
                                                                }

                                                                if ($perecent_fill == 100) {
                                                                    $load_modal = '';
                                                                    $border = 'border-success';
                                                                    $bg_color = 'bg-success';
                                                                    $cursor = '';
                                                                } else {
                                                                    $load_modal = 'data-bs-toggle="modal"';
                                                                    $border = 'border-primary';
                                                                    $bg_color = '';
                                                                    $cursor = 'cursor: pointer';
                                                                }

                                                                if ($userType != '11') {
                                                                    $load_modal = '';
                                                                }

                                                                echo '<td>
                                                                    <div class="progress border  ' . $border . '" role="progressbar" aria-label="Example with label" aria-valuenow="' . $perecent_fill . '" aria-valuemin="0" aria-valuemax="100" ' . $load_modal . '" data-bs-target="#paymentModal" data-booking-id="' . $booking['id'] . '" data-booking-fullamt="' . $booking_full_amt . '" data-booking-paytype="' . $booking_bill['pay_type'] . '" data-booking-fill="' . $perecent_fill . '"';


                                                                if ($perecent_fill == 40) {
                                                                    echo ' data-remaining-amt="' . $booking_bill['part_pay_2'] + $booking_bill['part_pay_3'] . '" data-pending-amt="' . $booking_bill['part_pay_2'] . '"';
                                                                } else if ($perecent_fill == 70) {
                                                                    echo ' data-remaining-amt="' . $booking_bill['part_pay_3'] . '"data-pending-amt="' . $booking_bill['part_pay_3'] . '"';
                                                                } else if ($perecent_fill == 50) {
                                                                    echo ' data-remaining-amt="' . $booking_bill['part_pay_2'] . '" data-pending-amt="' . $booking_bill['part_pay_2'] . '"';
                                                                }

                                                                echo '>
                                                                                <div class="progress-bar ' . $bg_color . '" style="width: ' . $perecent_fill . '%; height:10px; ' . $cursor . '">' . $perecent_fill . '%</div>
                                                                            </div>
                                                                            <div id="" class="my-2 text-center">Paid Rs.' . $booking_paid_amt . ' of Rs.' . $booking_full_amt . '</div>
                                                                      </td>';
                                                                echo '<td>';
                                                                $startDate = new DateTime($booking['date']); // Convert to DateTime object

                                                                $tourDays = !empty($booking['tour_days']) ? (int)$booking['tour_days'] : 0; // Ensure it's an integer

                                                                $endDate = clone $startDate; // Clone to avoid modifying original date
                                                                $endDate->modify("+$tourDays days"); // Add tour days

                                                                $today = new DateTime(); // Get the current date
                                                                $today->setTime(0, 0); // Reset time for accurate comparison

                                                                if ($booking['status'] === '2') { // Canceled
                                                                    echo '<div class="d-block">
                                                                    <a href="#">
                                                                        <button type="button" class="btn text-danger-emphasis bg-danger-subtle border border-danger-subtle rounded-3 fw-bolder">Canceled</button>
                                                                    </a>
                                                                  </div>';
                                                                } else if ($booking['status'] === '3') { // Refunded
                                                                    echo '<div class="d-block">
                                                                    <a href="#">
                                                                        <button type="button" class="btn text-secondary-emphasis bg-secondary-subtle border border-secondary-subtle rounded-3 fw-bolder show-refund-msg" data-id="' . $booking['id'] . '">Refunded</button>
                                                                    </a>
                                                                  </div>';
                                                                } else if ($today > $endDate) { // Completed
                                                                    echo '<div class="d-block">
                                                                    <a href="#">
                                                                        <button type="button" class="btn text-success-emphasis bg-success-subtle border border-success-subtle rounded-3 fw-bolder">Completed</button>
                                                                    </a>
                                                                  </div>';
                                                                } else if ($today >= $startDate && $today <= $endDate) { // In Progress
                                                                    echo '<div class="d-block">
                                                                    <a href="#">
                                                                        <button type="button" class="btn text-info-emphasis bg-info-subtle border border-info-subtle rounded-3 fw-bolder">In Progress</button>
                                                                    </a>
                                                                  </div>';
                                                                } else { // Upcoming
                                                                    echo '<div class="d-block">
                                                                    <a href="#">
                                                                        <button type="button" class="btn text-primary-emphasis bg-primary-subtle border border-primary-subtle rounded-3 fw-bolder">Upcoming</button>
                                                                    </a>
                                                                  </div>';
                                                                }
                                                                echo '<td class="text-center">
                                                                        <div class="dropdown mt-">
                                                                            <a class="" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false"><i class="fa solid fa-ellipsis pe-3" style="color: grey;"></i></a>
                                                                            <div class="dropdown-menu" id="dr-users" aria-labelledby="dropdownMenuButton">
                                                                                <a class="dropdown-item" href="tour_details.php?id=' . urlencode($booking["id"]) . '"><i class="fa-solid fa-eye"></i> View</a>';
                                                                if ($today < $endDate && $booking['status'] != '2' && $booking['status'] != '3') {
                                                                    echo '<a class="dropdown-item" href="#" id="cancelBooking" data-booking-id="' . urlencode($booking["id"]) . '" data-order-id="' . urlencode($booking["order_id"]) . '"><i class="mdi mdi-trash-can font-size-16 text-dark"></i> Cancel Booking</a>';
                                                                }
                                                                echo '</div>
                                                                        </div> 
                                                                    </td>';
                                                                echo '</tr>';
                                                            }
                                                        }
                                                        ?>

                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Payment Screen start -->
                            <div class="modal fade" id="paymentModal" tabindex="-1" aria-labelledby="paymentModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Payment</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="col-md-8 col-sm-8 col-12">
                                                    <input type="hidden" id="modalBookingId">
                                                    <p class="fw-bold text-muted fs-6">Amount to be Paid: <span class="fw-bolder" id="amountToBePaid" style="color: var(--pure-black);"></span>

                                                    </p>
                                                    <p class="fw-bold text-muted fs-6">Available TopUp Balance:
                                                        <span class="fw-bolder" style="color: var(--pure-black);" id="avalableBalance">
                                                            <?php
                                                            // Only for TA login
                                                            require 'connect.php';
                                                            // Check if user exists
                                                            $stmt1 = $conn->prepare("SELECT * FROM `login` WHERE status = '1' AND `user_id` = ? AND `user_type_id` = '11'");
                                                            $stmt1->execute([$userId]);
                                                            // Fetch the latest available balance for the given ta_id
                                                            $stmt2 = $conn->prepare("SELECT available_balance FROM ta_top_up_utilisation WHERE ta_id = :ta_id ORDER BY id DESC LIMIT 1");
                                                            $stmt2->execute(array(':ta_id' => $userId));
                                                            $result3 = $stmt2->fetch(PDO::FETCH_ASSOC);
                                                            $available_bal = ($result3['available_balance'] ?? 0);
                                                            echo $available_bal
                                                            ?>
                                                        </span>
                                                        <i class="ri-refresh-line fs-5" style="color: red;"></i>
                                                        <span class="bg-danger-subtle text-danger py-1 px-2 mt-2 rounded-2 lowBal d-none" id="low_bal" style="color: red;">
                                                            Low Balance! Kindly TopUP
                                                        </span>
                                                    </p>
                                                </div>
                                                <div class="col-md-4 col-sm-4 col-12 text-end">
                                                    <a href="view_ta_topup.php" target="_blank">
                                                        <button type="button" class="btn text-dark-emphasis bg-dark-subtle border border-dark-subtle fw-bold">
                                                            <i class="ri-wallet-2-line" style="color: #615a5a;"></i>
                                                            Add TopUp
                                                        </button>
                                                    </a>
                                                </div>
                                            </div>
                                            <div>
                                                <!-- <p class="fs-6 fw-bolder py-3" style="color: var(--pure-black);">Pay Type</p>

                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio2" value="option2" checked>
                                                    <label class="form-check-label" for="inlineRadio2">Part</label>
                                                </div>
                                                <div id="toggleDiv">
                                                    <select class="form-select w-50" id="payTypeSelect" aria-label="Default select example">
                                                        <option selected value="--Select the Pay Type">--Select the Pay Type</option>
                                                        <option value="2">2 Parts</option>
                                                        <option value="3">3 Parts</option>
                                                    </select>
                                                </div> -->
                                                <div class="py-3" id="showamt">
                                                    <p class="fw-bolder fs-5 d-flex" style="color: var(--pure-black);">Amount:
                                                        <span><input class="form-control" type="text" id="amountInput" value="" aria-label="readonly input example" readonly></span>

                                                    </p>
                                                    <span class="fw-bold text-muted fs-6" id="showPayType"></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-primary" id="place_order">Pay</button>
                                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Payment Screen end -->
                            <!-- Cancel Booking -->
                            <div class="modal fade" id="cancelBookingModal" tabindex="-1" aria-labelledby="cancelBookingModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content rounded-3 shadow">
                                        <div class="modal-header text-light">
                                            <h5 class="modal-title" id="cancelBookingModalLabel">Cancel Booking</h5>
                                            <button type="button" class="btn-close btn-close-black" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label for="cancelReason" class="form-label">Are you sure you want to cancel this booking?</label>
                                                <textarea id="cancelReason" class="form-control" rows="3" placeholder="Reason (optional)"></textarea>
                                            </div>
                                            <span for="cancelReason" class="text-muted fst-italic">Note: Our operations team will get back to you regarding the refund after reviewing the product.</span>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-primary" data-bs-dismiss="modal" id="denyCancelBooking">No</button>
                                            <button type="button" class="btn btn-dark" id="confirmCancelBooking">Yes, Cancel</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Cancel Booking End -->
                            <!-- Refund status -->
                            <div class="modal fade" id="refundStatusModal" tabindex="-1" aria-labelledby="refundStatusModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content rounded-4">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="refundStatusModalLabel">Refund Status</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <p id="refundMessage">Loading message...</p>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Refund status end -->
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

            $("#paymentModal").on('show.bs.modal', function(event) {
                // Part Payment Modal Start
                const fullRadio = document.getElementById('inlineRadio1');
                const partRadio = document.getElementById('inlineRadio2');
                const payTypeSelect = document.getElementById('payTypeSelect');
                const amountInput = document.getElementById('amountInput');
                const divToToggle = document.getElementById('toggleDiv');
                // Fetch the total amount dynamically from the "Amount to be Paid" section
                const amountToBePaidElement = document.getElementById('amountToBePaid');
                //let totalAmount = parseInt(amountToBePaidElement.textContent.replace('₹', '').trim()); // Get amount without '₹' symbol
                // const totalAmount = document.getElementById('amountPaying');  // Amount to be Paid

                var button = $(event.relatedTarget);
                var paidfill = button.data("booking-fill");
                var bookingId = button.data("booking-id"); // Get the booking ID from the clicked button
                $("#modalBookingId").val(bookingId);
                var pending_amt = button.data("pending-amt");
                var remaining_amt = button.data("remaining-amt")
                $("#amountToBePaid").text(remaining_amt);
                $("#amountInput").val(pending_amt);
                var paytype = button.data("booking-paytype");
                var fullamt = button.data("booking-fullamt");
                var partamt;

                if (paytype == 3) {
                    if (paidfill == 40) {
                        $("#showPayType").text("2/3 part payment");
                        partamt = fullamt * 0.3;
                    }
                    if (paidfill == 70) {
                        $("#showPayType").text("3/3 part payment");
                        partamt = fullamt * 0.3;
                    }
                } else {
                    if (paidfill == 50) {
                        $("#showPayType").text("2/2 part payment");
                        partamt = fullamt / 2;
                    }
                }
                var ta_bal;
                setTimeout(function() {
                    ta_bal = $("#avalableBalance").text();
                    ta_bal = parseFloat(ta_bal);
                    console.log('pending_amt:' + partamt + ' ta_bal:' + ta_bal);

                    if (ta_bal < partamt) {
                        $("#low_bal").removeClass('d-none');
                        $("#low_bal").addClass('d-block');
                        $('#showamt').addClass('d-none');
                        $('#place_order').addClass('d-none');
                    } else {
                        $("#low_bal").removeClass('d-block');
                        $("#low_bal").addClass('d-none');
                        $('#showamt').removeClass('d-none');
                        $('#place_order').removeClass('d-none');
                    }
                }, 1000);

                $("#showPayType").text();

                //console.log('pending_amt:' + pending_amt);
            });
            $('#place_order').click(function() {
                var payAmt = $("#amountInput").val();
                var bookingId = $("#modalBookingId").val();
                $("#showPayType").text();
                var payType;
                var payID = makepayid(25);
                var partPayStatus = 1;
                var partPayCount;
                let text = $("#showPayType").text(); // Example text
                let numbers = text.match(/\d+/g); // Extracts all numbers

                if (numbers) {
                    partPayCount = parseInt(numbers[0]); // Extracts 2
                    payType = parseInt(numbers[1]); // Extracts 3
                }

                var overallStatus;
                //if 3 part pay type and 2 part is paid currently
                if (payType == 3 && partPayCount == 2) {
                    overallStatus = 0;
                } else {
                    overallStatus = 1;
                }
                var formdata = {

                    bookingId: bookingId,
                    payID: payID,
                    payAmt: payAmt,
                    payType: payType,
                    partPayStatus: partPayStatus,
                    partPayCount: partPayCount,
                    overallStatus: overallStatus
                };

                console.log("formdata");
                console.log(formdata);
                //pay pending amount
                let data = JSON.stringify(formdata);
                $.ajax({
                    type: "POST",
                    url: "tour_history/tour_paymet_action.php",
                    data: data,
                    contentType: "application/json", // Ensure the correct header
                    headers: {
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(res) {
                        console.log('res:' + res);
                        if (res.toString() == "1") {
                            console.log("success payment");

                            alert('Payment is successful')
                            location.reload();
                        } else {
                            alert("Payment failed");
                        }
                    },
                    error: function(err) {
                        console.log(err);
                    }
                });

                console.log("Place Order button clicked!");
            });
            let currentBookingId = null;
            let currentOrderId = null;

            document.getElementById('cancelBooking').addEventListener('click', function(e) {
                e.preventDefault();

                // Get booking ID from data attribute
                currentBookingId = this.getAttribute('data-booking-id');
                currentOderId = this.getAttribute('data-order-id');

                // Show the modal
                const modal = new bootstrap.Modal(document.getElementById('cancelBookingModal'));
                modal.show();
            });

            // Handle confirm button click
            document.getElementById('confirmCancelBooking').addEventListener('click', function() {
                const reason = $('#cancelReason').val().trim();
                let data = {
                    bookingId: currentBookingId,
                    orderId: currentOderId,
                    reason: reason
                }
                // TODO: Add your cancel logic here (AJAX, etc.)
                $.ajax({
                    type: "POST",
                    url: "tour_history/cancel_booking.php",
                    data: data,
                    success: function(res) {
                        console.log('res:' + res);
                        if (res.toString() == "1") {
                            alert("Booking has been canceled.");
                            location.reload();
                        } else {
                            alert("Booking cancelation failed.");
                        }
                    },
                    error: function(err) {
                        console.log(err);
                    }
                });

                bootstrap.Modal.getInstance(document.getElementById('cancelBookingModal')).hide();
            });

            // Handle cancel button click
            document.getElementById('denyCancelBooking').addEventListener('click', function() {
                bootstrap.Modal.getInstance(document.getElementById('cancelBookingModal')).hide();
            });
            $(document).on('click', '.show-refund-msg', function() {
                const bookingId = $(this).data('id');
                $('#refundMessage').text('Loading message...');

                const modal = new bootstrap.Modal(document.getElementById('refundStatusModal'));
                modal.show();

                $.ajax({
                    url: 'tour_history/get_refund_message.php',
                    type: 'POST',
                    data: {
                        booking_id: bookingId
                    },
                    success: function(response) {
                        if (response.status === 'success') {
                            $('#refundMessage').html(response.message.replace(/\n/g, '<br>'));
                        } else {
                            $('#refundMessage').text('No message found.');
                        }
                    },
                    error: function() {
                        $('#refundMessage').text('Failed to load message.');
                    }
                });
            });

        });





        function makepayid(length) {
            var result = 'Paid_';
            const timestamp = Date.now();
            var characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
            var charactersLength = characters.length;
            result += timestamp;
            for (var i = 0; i < length; i++) {
                result += characters.charAt(Math.floor(Math.random() *
                    charactersLength));
            }
            return result;
        }
    </script>
</body>

</html>