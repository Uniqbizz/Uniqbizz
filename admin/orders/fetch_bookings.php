<?php
$date_range = $_POST['date'];
// Split the date range using ' - ' as the separator
list($start_date, $end_date) = explode(" - ", $date_range);

// Convert both dates to Y-m-d format
$start_date_formatted = date("Y-m-d", strtotime($start_date));
$end_date_formatted = date("Y-m-d", strtotime($end_date));

// Output the formatted dates
// echo "Start Date: " . $start_date_formatted . "<br>";
// echo "End Date: " . $end_date_formatted;
?>
<div class="tab-content" id='tableList'>
    <div class="tab-pane fade card show active px-3 rounded-4" id="allHistory" role="tabpanel">
        <div class="col-lg-12 py-3">
            <div class="table-responsive table-desi">
                <table class="table table-hover" id="user_table1">
                    <thead>
                        <tr>
                            <th class="ceterText fw-bolder font-size-13">Sr. No.</th>
                            <th class="ceterText fw-bolder font-size-13">Booking ID</th>
                            <th class="ceterText fw-bolder font-size-13">Tour Date</th>
                            <th class="ceterText fw-bolder font-size-13">Package Name</th>
                            <th class="ceterText fw-bolder font-size-13">Customer</th>
                            <th class="ceterText fw-bolder font-size-13">Travel Consultant</th>
                            <th class="ceterText fw-bolder font-size-13">Payment Status</th>
                            <th class="ceterText fw-bolder font-size-13">Status</th>
                            <th class="ceterText fw-bolder font-size-13">Action</th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php
                        require '../connect.php';

                        $sql0 = "SELECT ca_travelagency_id, firstname, lastname, email, contact_no FROM ca_travelagency WHERE status=1 ";
                        $stmt0 = $conn->prepare($sql0);
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
                                        b.status,
                                        b.confirm_status 
                                        FROM bookings b
                                        JOIN package p ON b.package_id = p.id
                                        WHERE b.ta_id IN ($ta_ids_str) AND b.date between '$start_date_formatted' AND '$end_date_formatted'"; // Use IN clause to match multiple IDs
                        }
                        $stmt = $conn->prepare($sql);
                        //print_r($stmt);
                        $stmt->execute();
                        $bookings = $stmt->fetchAll(PDO::FETCH_ASSOC);


                        // Check if bookings exist
                        if (empty($bookings)) {
                        ?>
                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td class="text-center">No Bookings Found</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                        <?php
                        }

                        $i = 0;

                        foreach ($bookings as $booking) {
                            $sql3 = "SELECT * FROM booking_direct_bill WHERE bookings_id = " . $booking['id'] . "";
                            $stmt3 = $conn->prepare($sql3);
                            $stmt3->execute();
                            $booking_bill = $stmt3->fetch(PDO::FETCH_ASSOC);
                            $formattedDate = date("d-m-Y", strtotime($booking['date']));
                        ?>
                            <tr>
                                <td><?= ++$i ?></td>
                                <td><?= $booking['order_id'] ?></td>
                                <td><?= $formattedDate ?></td>
                                <td><?= $booking['package_name'] ?></td>
                                <td><?= $booking['c_name'] . '(' . $booking['customer_id'] . ')<br>' . $booking['phone'] . '<br>' . $booking['email'] ?></td>
                                <?php
                                $ta_id = $booking['ta_id']; // Get the agency ID from booking

                                // Retrieve travel agency details safely
                                $agency_info = isset($ta_details[$ta_id]) ? $ta_details[$ta_id] : ['firstname' => '', 'lastname' => '', 'email' => '', 'phone' => ''];

                                ?>
                                <td><?= $agency_info['firstname'] . ' ' . $agency_info['lastname'] . '<br>' . $agency_info['phone'] . '<br>' . $agency_info['email'] ?></td>
                                <?php
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
                                    $onclickPending='';
                                } else {
                                    $load_modal = '';
                                    $border = 'border-primary';
                                    $bg_color = '';
                                    $cursor = 'cursor: pointer';
                                    $onclickPending = ' onclick="window.location.href=\'view_placeOrder?id='.$booking['id'].'\'"';
                                }
                                ?>
                                <?php
                                    $data_remaining_amt = '';
                                    $data_pending_amt = '';

                                    if ($perecent_fill == 40) {
                                        $data_remaining_amt = $booking_bill['part_pay_2'] + $booking_bill['part_pay_3'];
                                        $data_pending_amt = $booking_bill['part_pay_2'];
                                        
                                    } else if ($perecent_fill == 70) {
                                        $data_remaining_amt = $booking_bill['part_pay_3'];
                                        $data_pending_amt = $booking_bill['part_pay_3'];
                                    } else if ($perecent_fill == 50) {
                                        $data_remaining_amt = $booking_bill['part_pay_2'];
                                        $data_pending_amt = $booking_bill['part_pay_2'];
                                    }
                                ?>

                                <td>
                                    <div class="progress border <?= $border ?>" role="progressbar" aria-label="Example with label"
                                        aria-valuenow="<?= $perecent_fill ?>" aria-valuemin="0" aria-valuemax="100"
                                        <?= $load_modal ?> data-bs-target="#paymentModal"
                                        data-booking-id="<?= $booking['id'] ?>"
                                        data-booking-fullamt="<?= $booking_full_amt ?>"
                                        data-booking-paytype="<?= $booking_bill['pay_type'] ?>"
                                        data-booking-fill="<?= $perecent_fill ?>"
                                        <?= $data_remaining_amt !== '' ? 'data-remaining-amt="' . $data_remaining_amt . '"' : '' ?>
                                        <?= $data_pending_amt !== '' ? 'data-pending-amt="' . $data_pending_amt . '"' : '' ?>
                                        <?=$onclickPending?>
                                    >
                                        <div class="progress-bar <?= $bg_color ?>" style="width: <?= $perecent_fill ?>%; height:10px; <?= $cursor ?>">
                                            <?= $perecent_fill ?>%
                                        </div>
                                    </div>
                                    <div class="my-2 text-center">Paid Rs.<?= $booking_paid_amt ?> of Rs.<?= $booking_full_amt ?></div>
                                </td>
                                <td>
                                    <?php
                                    $startDate = new DateTime($booking['date']); // Convert to DateTime object

                                    $tourDays = !empty($booking['tour_days']) ? (int)$booking['tour_days'] : 0; // Ensure it's an integer

                                    $endDate = clone $startDate; // Clone to avoid modifying original date
                                    $endDate->modify("+$tourDays days"); // Add tour days

                                    $today = new DateTime(); // Get the current date
                                    $today->setTime(0, 0); // Reset time for accurate comparison

                                    if ($booking['status'] === '2') { // Canceled
                                    ?>
                                        <div class="d-block">
                                            <a href="#">
                                                <button type="button" class="btn text-danger-emphasis bg-danger-subtle border border-danger-subtle rounded-3 fw-bolder show-cancel-msg" data-id="<?= $booking['id'] ?>">Canceled
                                                </button>
                                            </a>
                                        </div>
                                    <?php
                                    } else if ($booking['status'] === '3') { // Refunded
                                    ?>
                                        <div class="d-block">
                                            <a href="#">
                                                <button type="button" class="btn text-secondary-emphasis bg-secondary-subtle border border-secondary-subtle rounded-3 fw-bolder">Refunded</button>
                                            </a>
                                        </div>
                                    <?php
                                        } else if ($booking['confirm_status'] == 0){ // Pending
                                    ?>
                                        <div class="d-block">
                                            <button type="button" class="btn text-primary-emphasis bg-primary-subtle border border-primary-subtle rounded-3 fw-bolder open-status-modal"
                                                data-bs-toggle="modal" data-bs-target="#confirmStatusModal" data-border-id="<?= $booking['order_id'] ?>">
                                                Pending
                                            </button>
                                        </div>
                                    <?php
                                        } else if ($booking['confirm_status'] == 1 && $today < $startDate){ // Confirmed
                                    ?>
                                        <div class="d-block">
                                            <a href="#">
                                                <button type="button" class="btn text-primary-emphasis bg-primary-subtle border border-primary-subtle rounded-3 fw-bolder">
                                                    Confirmed
                                                </button>
                                            </a>
                                        </div>
                                    
                                    <?php
                                        } else if ($today > $endDate) { // Completed
                                    ?>
                                        <div class="d-block">
                                            <a href="#">
                                                <button type="button" class="btn text-success-emphasis bg-success-subtle border border-success-subtle rounded-3 fw-bolder">
                                                    Completed
                                                </button>
                                            </a>
                                        </div>
                                    <?php
                                        } else if ($today >= $startDate && $today <= $endDate) { // Traveling
                                    ?>
                                        <div class="d-block">
                                            <a href="#">
                                                <button type="button" class="btn text-info-emphasis bg-info-subtle border border-info-subtle rounded-3 fw-bolder">
                                                    Traveling
                                                </button>
                                            </a>
                                        </div>
                                    <?php } ?>

                                </td>
                                <td class="text-center">
                                    <div class="dropdown">
                                        <a id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false"><i class="fa-solid fa-ellipsis pe-3" style="color: grey;"></i></a>
                                        <div class="dropdown-menu" id="dr-users" aria-labelledby="dropdownMenuButton">
                                            <a class="dropdown-item" href="order_details.php?id=<?= urlencode($booking["id"]) ?>"><i class="fa-solid fa-eye"></i> View</a>
                                            <a class="dropdown-item" href="dowload_pack_details.php?id=<?= urldecode($booking["package_id"]) ?>" id="generatePDF"><i class="fa-solid fa-arrow-down"></i> Download Details</a>
                                            <?php
                                            if ($booking['status'] === '2') {
                                            ?>
                                                <a class="dropdown-item" href="#" id="refundAction" data-order-id=<?= $booking["id"] ?>>
                                                    <i class="fa-solid fa-money-bill-transfer"></i> Initiate Refund
                                                </a>
                                            <?php
                                            }
                                            ?>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
                <!-- pegination start -->
                <div class="center text-center" id="pagination_row"></div>
            </div>
        </div>
    </div>
    <div class="tab-pane fade card show px-3 rounded-4" id="pendingHistory" role="tabpanel">
        <div class="col-lg-12 py-3">
            <div class="table-responsive table-desi">
                <table class="table table-hover" id="user_table2">
                    <thead>
                        <tr>
                            <th class="ceterText fw-bolder font-size-13">Sr. No.</th>
                            <th class="ceterText fw-bolder font-size-13">Booking ID</th>
                            <th class="ceterText fw-bolder font-size-13">Tour Date</th>
                            <th class="ceterText fw-bolder font-size-13">Package Name</th>
                            <th class="ceterText fw-bolder font-size-13">Customer</th>
                            <th class="ceterText fw-bolder font-size-13">Travel Consultant</th>
                            <th class="ceterText fw-bolder font-size-13">Payment Status</th>
                            <th class="ceterText fw-bolder font-size-13">Status</th>
                            <th class="ceterText fw-bolder font-size-13">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        require '../connect.php';

                        // Fetch Travel Agencies
                        $sql0 = "SELECT ca_travelagency_id, firstname, lastname, email, contact_no FROM ca_travelagency WHERE status=1";
                        $stmt0 = $conn->prepare($sql0);
                        $stmt0->execute();
                        $ta_list = $stmt0->fetchAll(PDO::FETCH_ASSOC);

                        // Check if travel agencies exist
                        if (empty($ta_list)) {
                            echo '<tr><td colspan="9" class="text-center fw-bold">No Travel Agencies Found</td></tr>';
                            // exit; // Stop further execution
                        }
                        // Travel Agency Mapping
                        $ta_details = [];
                        $ta_ids = [];
                        foreach ($ta_list as $ta) {
                            $ta_ids[] = $ta['ca_travelagency_id'];
                            $ta_details[$ta['ca_travelagency_id']] = [
                                'firstname' => $ta['firstname'],
                                'lastname' => $ta['lastname'],
                                'email' => $ta['email'],
                                'phone' => $ta['contact_no']
                            ];
                        }

                        // Convert IDs to SQL format
                        $ta_ids_str = "'" . implode("','", $ta_ids) . "'";

                        // Fetch Bookings
                        $sql = "
                                    SELECT b.id, b.order_id, b.customer_id, b.package_id, p.name AS package_name, 
                                    p.tour_days, b.name AS c_name, b.phone, b.email, b.date, b.ta_id, b.confirm_status 
                                    FROM bookings b
                                    JOIN package p ON b.package_id = p.id
                                    WHERE b.ta_id IN ($ta_ids_str) AND b.date between '$start_date_formatted' AND '$end_date_formatted' AND (b.status ='0' OR b.confirm_status=0)
                                    ";

                        // Debugging: Log SQL query and TA IDs
                        // echo "<script>console.log('TA List: " . json_encode($ta_list) . "');</script>";
                        // echo "<script>console.log('🔍 SQL Query: " . addslashes($sql) . "');</script>";
                        // echo "<script>console.log('🆔 TA IDs: " . addslashes($ta_ids_str) . "');</script>";
                        $stmt = $conn->prepare($sql);
                        //print_r($stmt);
                        $stmt->execute();
                        $bookings = $stmt->fetchAll(PDO::FETCH_ASSOC);



                        // Check if bookings exist
                        if (empty($bookings)) {
                        ?>
                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td class="text-center">No Bookings Found</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                        <?php }

                        $i = 0;
                        //$data_found = false;
                        foreach ($bookings as $booking) {
                            $sql3 = "SELECT * FROM booking_direct_bill WHERE bookings_id = " . $booking['id'];
                            $stmt3 = $conn->prepare($sql3);
                            $stmt3->execute();
                            $booking_bill = $stmt3->fetch(PDO::FETCH_ASSOC);
                            $formattedDate = date("d-m-Y", strtotime($booking['date']));

                            // Tour Status Calculation
                            $startDate = new DateTime($booking['date']);
                            $tourDays = (int)$booking['tour_days'];
                            $endDate = clone $startDate;
                            $endDate->modify("+$tourDays days");

                            $today = new DateTime();
                            $today->setTime(0, 0);
                            $endDate->setTime(0, 0);

                            if ($today > $endDate) {
                                continue;
                            }

                            //$data_found = true;
                        ?>
                            <tr>
                                <td><?= ++$i ?></td>
                                <td><?= $booking['order_id'] ?></td>
                                <td><?= $formattedDate ?></td>
                                <td><?= $booking['package_name'] ?></td>
                                <td><?= $booking['c_name'] . '(' . $booking['customer_id'] . ')<br>' . $booking['phone'] . '<br>' . $booking['email'] ?></td>

                                <?php
                                $ta_id = $booking['ta_id'];
                                $agency_info = $ta_details[$ta_id] ?? ['firstname' => '', 'lastname' => '', 'email' => '', 'phone' => ''];

                                ?>
                                <td><?= $agency_info['firstname'] . ' ' . $agency_info['lastname'] . '<br>' . $agency_info['phone'] . '<br>' . $agency_info['email'] ?></td>
                                <?php
                                // Payment Progress Calculation
                                $perecent_fill = 0;
                                $booking_paid_amt = 0;
                                $booking_full_amt = 0;

                                if ($booking_bill) {
                                    $pay_type = $booking_bill['pay_type'];
                                    $final_price = $booking_bill['final_price'];
                                    $onclickPending = ' onclick="window.location.href=\'view_placeOrder?id='.$booking['id'].'\'"';
                                    if ($pay_type == 2) {
                                        if ($booking_bill['part_pay_1_status'] == 1 && $booking_bill['part_pay_2_status'] == 0) {
                                            $perecent_fill = 50;
                                            $booking_paid_amt = $booking_bill['part_pay_1'];
                                        } elseif ($booking_bill['part_pay_1_status'] == 1 && $booking_bill['part_pay_2_status'] == 1) {
                                            $perecent_fill = 100;
                                            $booking_paid_amt = $booking_bill['part_pay_1'] + $booking_bill['part_pay_2'];
                                        }
                                    } elseif ($pay_type == 3) {
                                        if ($booking_bill['part_pay_1_status'] == 1 && $booking_bill['part_pay_2_status'] == 0 && $booking_bill['part_pay_3_status'] == 0) {
                                            $perecent_fill = 40;
                                            $booking_paid_amt = $booking_bill['part_pay_1'];
                                        } elseif ($booking_bill['part_pay_1_status'] == 1 && $booking_bill['part_pay_2_status'] == 1 && $booking_bill['part_pay_3_status'] == 0) {
                                            $perecent_fill = 70;
                                            $booking_paid_amt = $booking_bill['part_pay_1'] + $booking_bill['part_pay_2'];
                                        } elseif ($booking_bill['part_pay_1_status'] == 1 && $booking_bill['part_pay_2_status'] == 1 && $booking_bill['part_pay_3_status'] == 1) {
                                            $perecent_fill = 100;
                                            $booking_paid_amt = $booking_bill['part_pay_1'] + $booking_bill['part_pay_2'] + $booking_bill['part_pay_3'];
                                        }
                                    } else {
                                        $perecent_fill = 100;
                                        $booking_paid_amt = $booking_bill['amount'];
                                    }

                                    $booking_full_amt = $final_price;
                                }

                                ?>
                                <td>
                                    <div class="progress border <?= ($perecent_fill == 100 ? 'border-success' : 'border-primary') ?>" role="progressbar"
                                        aria-valuenow="<?= $perecent_fill ?>" aria-valuemin="0" aria-valuemax="100" <?=$onclickPending?>>
                                        <div class="progress-bar <?= ($perecent_fill == 100 ? 'bg-success' : '') ?>" style="width: <?= $perecent_fill ?>%;">
                                            <?= $perecent_fill ?>%
                                        </div>
                                    </div>
                                    <div class="my-2 text-center">Paid Rs.<?= $booking_paid_amt . ' of Rs.' . $booking_full_amt ?></div>
                                </td>

                                <?php if ( $booking['confirm_status'] == 0 ) { ?>
                                    <td><button class="btn text-primary-emphasis bg-primary-subtle border border-primary-subtle rounded-3 fw-bolder">Pending</button></td>
                                <?php } else if ( $booking['confirm_status'] == 1 && $today >= $startDate && $today <= $endDate) { ?>
                                        <td>
                                            <div class="d-block">
                                                <a href="#">
                                                    <button type="button" class="btn text-info-emphasis bg-info-subtle border border-info-subtle rounded-3 fw-bolder">In Transit</button>
                                                </a>
                                            </div>
                                        </td>
                                        
                                <?php } ?>
                                <td class="text-center">
                                    <div class="dropdown mt-">
                                        <a class="" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false"><i class="fa solid fa-ellipsis pe-3" style="color: grey;"></i></a>
                                        <div class="dropdown-menu" id="dr-users" aria-labelledby="dropdownMenuButton">
                                            <a class="dropdown-item" href="order_details.php?id=<?= urlencode($booking["id"]) ?>"><i class="fa-solid fa-eye"></i> View</a>
                                            <a class="dropdown-item" href="dowload_pack_details.php?id=<?= urldecode($booking["package_id"]) ?>" id="generatePDF"><i class="fa-solid fa-arrow-down"></i> Download Details</a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
                <!-- pegination start -->
                <div class="center text-center" id="pagination_row"></div>
            </div>
        </div>
    </div>
    <div class="tab-pane fade card show px-3 rounded-4" id="bookedHistory" role="tabpanel">
        <div class="col-lg-12 py-3">
            <div class="table-responsive table-desi">
                <table class="table table-hover" id="user_table3">
                    <thead>
                        <tr>
                            <th class="ceterText fw-bolder font-size-13">Sr. No.</th>
                            <th class="ceterText fw-bolder font-size-13">Booking ID</th>
                            <th class="ceterText fw-bolder font-size-13">Tour Date</th>
                            <th class="ceterText fw-bolder font-size-13">Package Name</th>
                            <th class="ceterText fw-bolder font-size-13">Customer</th>
                            <th class="ceterText fw-bolder font-size-13">Travel Consultant</th>
                            <th class="ceterText fw-bolder font-size-13">Payment Status</th>
                            <th class="ceterText fw-bolder font-size-13">Status</th>
                            <th class="ceterText fw-bolder font-size-13">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        require '../connect.php';

                        $sql0 = "SELECT ca_travelagency_id, firstname, lastname, email, contact_no FROM ca_travelagency WHERE status=1 ";
                        $stmt0 = $conn->prepare($sql0);
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
                                                b.status,
                                                b.confirm_status
                                            FROM bookings b
                                            JOIN package p ON b.package_id = p.id
                                            WHERE b.ta_id IN ($ta_ids_str) AND b.date between '$start_date_formatted' AND '$end_date_formatted' AND b.status='1' AND b.confirm_status=1"; // Use IN clause to match multiple IDs
                        }

                        $stmt = $conn->prepare($sql);
                        $stmt->execute();
                        $bookings = $stmt->fetchAll(PDO::FETCH_ASSOC);


                        // Check if bookings exist
                        if (empty($bookings)) {
                        ?>
                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td class="text-center">No Bookings Found</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                        <?php
                        }
                        $i = 0;
                        foreach ($bookings as $booking) {
                            $sql3 = "SELECT * FROM booking_direct_bill WHERE bookings_id = " . $booking['id'];
                            $stmt3 = $conn->prepare($sql3);
                            $stmt3->execute();
                            $booking_bill = $stmt3->fetch(PDO::FETCH_ASSOC);

                            $formattedDate = date("d-m-Y", strtotime($booking['date']));

                            // Travel agency details
                            $ta_id = $booking['ta_id'];
                            $agency_info = isset($ta_details[$ta_id]) ? $ta_details[$ta_id] : ['firstname' => '', 'lastname' => '', 'email' => '', 'phone' => ''];

                            // Payment calculations
                            if ($booking_bill['pay_type'] == 2) {
                                if ($booking_bill['part_pay_1_status'] == 1 && $booking_bill['part_pay_2_status'] == 0) {
                                    continue; // Skip if not fully paid
                                } elseif ($booking_bill['part_pay_1_status'] == 1 && $booking_bill['part_pay_2_status'] == 1) {
                                    $perecent_fill = 100;
                                    $booking_paid_amt = $booking_bill['part_pay_1'] + $booking_bill['part_pay_2'];
                                    $booking_full_amt = $booking_bill['final_price'];
                                }
                            } else if ($booking_bill['pay_type'] == 3) {
                                if ($booking_bill['part_pay_1_status'] == 1 && $booking_bill['part_pay_2_status'] == 0 && $booking_bill['part_pay_3_status'] == 0) {
                                    continue;
                                } elseif ($booking_bill['part_pay_1_status'] == 1 && $booking_bill['part_pay_2_status'] == 1 && $booking_bill['part_pay_3_status'] == 0) {
                                    continue;
                                } elseif ($booking_bill['part_pay_1_status'] == 1 && $booking_bill['part_pay_2_status'] == 1 && $booking_bill['part_pay_3_status'] == 1) {
                                    $perecent_fill = 100;
                                    $booking_paid_amt = $booking_bill['part_pay_1'] + $booking_bill['part_pay_2'] + $booking_bill['part_pay_3'];
                                    $booking_full_amt = $booking_bill['final_price'];
                                }
                            } else {
                                $perecent_fill = 100;
                                $booking_paid_amt = $booking_bill['amount'];
                                $booking_full_amt = $booking_bill['final_price'];
                            }

                            // **Skip entry if `$perecent_fill` is not 100**
                            if ($perecent_fill !== 100) {
                                continue;
                            }

                            // Display the booking details
                        ?>
                            <tr>
                                <td><?= ++$i ?></td>
                                <td><?= $booking['order_id'] ?></td>
                                <td><?= $formattedDate ?></td>
                                <td><?= $booking['package_name'] ?></td>
                                <td><?= $booking['c_name'] . '(' . $booking['customer_id'] . ')<br>' . $booking['phone'] . '<br>' . $booking['email'] ?></td>
                                <td><?= $agency_info['firstname'] . ' ' . $agency_info['lastname'] . '<br>' . $agency_info['phone'] . '<br>' . $agency_info['email'] ?></td>

                                <td>
                                    <div class="progress border border-success" role="progressbar" aria-valuenow="<?= $perecent_fill ?>" aria-valuemin="0" aria-valuemax="100">
                                        <div class="progress-bar bg-success" style="width: <?= $perecent_fill ?>%; height:10px;"><?= $perecent_fill ?>%</div>
                                    </div>
                                    <div class="my-2 text-center">Paid Rs.<?= $booking_paid_amt . ' of Rs.' . $booking_full_amt ?></div>
                                </td>
                                <?php
                                // Tour completion status
                                $startDate = new DateTime($booking['date']);
                                $tourDays = !empty($booking['tour_days']) ? (int)$booking['tour_days'] : 0;
                                $endDate = clone $startDate;
                                $endDate->modify("+$tourDays days");
                                $today = new DateTime();
                                $today->setTime(0, 0);

                                if ($today > $endDate) {
                                ?>
                                    <td>
                                        <div class="d-block">
                                            <a href="#">
                                                <button type="button" class="btn text-info-emphasis bg-info-subtle border border-info-subtle rounded-3 fw-bolder">In Transit</button>
                                            </a>
                                        </div>
                                    </td>
                                <?php } else if ($today >= $startDate && $today <= $endDate  && ($booking['status'] === '0' || $booking['status'] === '1')) { ?>
                                    <td>
                                        <div class="d-block">
                                            <a href="#">
                                                <button type="button" class="btn text-info-emphasis bg-info-subtle border border-info-subtle rounded-3 fw-bolder">In Transit</button>
                                            </a>
                                        </div>
                                    </td>
                                <?php } else { ?>
                                    <td>
                                        <div class="d-block">
                                            <a href="#">
                                                <button type="button" class="btn text-primary-emphasis bg-primary-subtle border border-primary-subtle rounded-3 fw-bolder">Upcoming</button>
                                            </a>
                                        </div>
                                    </td>
                                <?php } ?>

                                <td class="text-center">
                                    <div class="dropdown mt-">
                                        <a class="" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false"><i class="fa solid fa-ellipsis pe-3" style="color: grey;"></i></a>
                                        <div class="dropdown-menu" id="dr-users" aria-labelledby="dropdownMenuButton">
                                            <a class="dropdown-item" href="order_details.php?id=<?= urlencode($booking["id"]) ?>"><i class="fa-solid fa-eye"></i> View</a>
                                            <a class="dropdown-item" href="dowload_pack_details.php?id=<?= urldecode($booking["package_id"]) ?>" id="generatePDF"><i class="fa-solid fa-arrow-down"></i> Download Details</a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
                <!-- pegination start -->
                <div class="center text-center" id="pagination_row"></div>
            </div>
        </div>
    </div>
    <div class="tab-pane fade card show px-3 rounded-4" id="canceledHistory" role="tabpanel">
        <div class="col-lg-12 py-3">
            <div class="table-responsive table-desi">
                <table class="table table-hover" id="user_table4">
                    <thead>
                        <tr>
                            <th class="ceterText fw-bolder font-size-13">Sr. No.</th>
                            <th class="ceterText fw-bolder font-size-13">Booking ID</th>
                            <th class="ceterText fw-bolder font-size-13">Tour Date</th>
                            <th class="ceterText fw-bolder font-size-13">Package Name</th>
                            <th class="ceterText fw-bolder font-size-13">Customer</th>
                            <th class="ceterText fw-bolder font-size-13">Travel Consultant</th>
                            <th class="ceterText fw-bolder font-size-13">Payment Status</th>
                            <th class="ceterText fw-bolder font-size-13">Status</th>
                            <th class="ceterText fw-bolder font-size-13">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        require '../connect.php';

                        $sql0 = "SELECT ca_travelagency_id, firstname, lastname, email, contact_no FROM ca_travelagency WHERE status=1 ";
                        $stmt0 = $conn->prepare($sql0);
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
                                            WHERE b.ta_id IN ($ta_ids_str) AND b.date between '$start_date_formatted' AND '$end_date_formatted' AND b.status='2'"; // Use IN clause to match multiple IDs
                        }

                        $stmt = $conn->prepare($sql);
                        $stmt->execute();
                        $bookings = $stmt->fetchAll(PDO::FETCH_ASSOC);


                        // Check if bookings exist
                        if (empty($bookings)) {
                        ?>
                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td class="text-center">No Bookings Found</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                        <?php
                        }
                        $i = 0;
                        foreach ($bookings as $booking) {
                            $sql3 = "SELECT * FROM booking_direct_bill WHERE bookings_id = " . $booking['id'] . "";
                            $stmt3 = $conn->prepare($sql3);
                            $stmt3->execute();
                            $booking_bill = $stmt3->fetch(PDO::FETCH_ASSOC);
                            //echo $booking['id'];
                            if (!$booking_bill) {
                                continue; // Skip this booking if no matching record is found
                            }
                            $formattedDate = date("d-m-Y", strtotime($booking['date']));
                        ?>
                            <tr>
                                <td><?= ++$i ?></td>
                                <td><?= $booking['order_id'] ?></td>
                                <td><?= $formattedDate ?></td>
                                <td><?= $booking['package_name'] ?></td>
                                <td><? $booking['c_name'] . '(' . $booking['customer_id'] . ')<br>' . $booking['phone'] . '<br>' . $booking['email'] ?></td>
                                <?php
                                $ta_id = $booking['ta_id']; // Get the agency ID from booking

                                // Retrieve travel agency details safely
                                $agency_info = isset($ta_details[$ta_id]) ? $ta_details[$ta_id] : ['firstname' => '', 'lastname' => '', 'email' => '', 'phone' => ''];
                                ?>
                                <td><?= $agency_info['firstname'] . ' ' . $agency_info['lastname'] . '<br>' . $agency_info['phone'] . '<br>' . $agency_info['email'] ?></td>
                                <?php
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
                                    $load_modal = '';
                                    $border = 'border-primary';
                                    $bg_color = '';
                                    $cursor = 'cursor: pointer';
                                }
                                ?>
                                <?php
                                    $data_remaining_amt = '';
                                    $data_pending_amt = '';

                                    if ($perecent_fill == 40) {
                                        $data_remaining_amt = $booking_bill['part_pay_2'] + $booking_bill['part_pay_3'];
                                        $data_pending_amt = $booking_bill['part_pay_2'];
                                    } else if ($perecent_fill == 70) {
                                        $data_remaining_amt = $booking_bill['part_pay_3'];
                                        $data_pending_amt = $booking_bill['part_pay_3'];
                                    } else if ($perecent_fill == 50) {
                                        $data_remaining_amt = $booking_bill['part_pay_2'];
                                        $data_pending_amt = $booking_bill['part_pay_2'];
                                    }
                                ?>

                                <td>
                                    <div class="progress border <?= $border ?>" role="progressbar" aria-label="Example with label"
                                        aria-valuenow="<?= $perecent_fill ?>" aria-valuemin="0" aria-valuemax="100"
                                        <?= $load_modal ?> data-bs-target="#paymentModal"
                                        data-booking-id="<?= $booking['id'] ?>"
                                        data-booking-fullamt="<?= $booking_full_amt ?>"
                                        data-booking-paytype="<?= $booking_bill['pay_type'] ?>"
                                        data-booking-fill="<?= $perecent_fill ?>"
                                        <?= $data_remaining_amt !== '' ? 'data-remaining-amt="' . $data_remaining_amt . '"' : '' ?>
                                        <?= $data_pending_amt !== '' ? 'data-pending-amt="' . $data_pending_amt . '"' : '' ?>
                                    >
                                        <div class="progress-bar <?= $bg_color ?>" style="width: <?= $perecent_fill ?>%; height:10px; <?= $cursor ?>">
                                            <?= $perecent_fill ?>%
                                        </div>
                                    </div>
                                    <div class="my-2 text-center">Paid Rs.<?= $booking_paid_amt ?> of Rs.<?= $booking_full_amt ?></div>
                                </td>
                                <td>
                                    <div class="d-block">
                                        <a href="#">
                                            <button type="button" class="btn text-danger-emphasis bg-danger-subtle border border-danger-subtle rounded-3 fw-bolder show-cancel-msg" data-id="<?= $booking['id'] ?>">Canceled</button>
                                        </a>
                                    </div>
                                <td class="text-center">
                                    <div class="dropdown mt-">
                                        <a class="" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false"><i class="fa solid fa-ellipsis pe-3" style="color: grey;"></i></a>
                                        <div class="dropdown-menu" id="dr-users" aria-labelledby="dropdownMenuButton">
                                            <a class="dropdown-item" href="order_details.php?id=<?= urlencode($booking["id"]) ?>"><i class="fa-solid fa-eye"></i> View</a>
                                            <a class="dropdown-item" href="dowload_pack_details.php?id=<?= urldecode($booking["package_id"]) ?>" id="generatePDF"><i class="fa-solid fa-arrow-down"></i> Download Details</a>
                                            <a class="dropdown-item refundAction" href="#" data-order-id=<?= $booking["id"] ?>><i class="fa-solid fa-money-bill-transfer"></i> Initiate Refund</a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
                <!-- pegination start -->
                <div class="center text-center" id="pagination_row"></div>
            </div>
        </div>
    </div>
    <div class="tab-pane fade card show px-3 rounded-4" id="refundHistory" role="tabpanel">
        <div class="col-lg-12 py-3">
            <div class="table-responsive table-desi">
                <table class="table table-hover" id="user_table5">
                    <thead>
                        <tr>
                            <th class="ceterText fw-bolder font-size-13">Sr. No.</th>
                            <th class="ceterText fw-bolder font-size-13">Booking ID</th>
                            <th class="ceterText fw-bolder font-size-13">Tour Date</th>
                            <th class="ceterText fw-bolder font-size-13">Package Name</th>
                            <th class="ceterText fw-bolder font-size-13">Customer</th>
                            <th class="ceterText fw-bolder font-size-13">Travel Consultant</th>
                            <th class="ceterText fw-bolder font-size-13">Payment Status</th>
                            <th class="ceterText fw-bolder font-size-13">Status</th>
                            <th class="ceterText fw-bolder font-size-13">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        require '../connect.php';

                        $sql0 = "SELECT ca_travelagency_id, firstname, lastname, email, contact_no FROM ca_travelagency WHERE status=1 ";
                        $stmt0 = $conn->prepare($sql0);
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
                                            WHERE b.ta_id IN ($ta_ids_str) AND b.date between '$start_date_formatted' AND '$end_date_formatted' AND b.status='3'"; // Use IN clause to match multiple IDs
                        }

                        $stmt = $conn->prepare($sql);
                        $stmt->execute();
                        $bookings = $stmt->fetchAll(PDO::FETCH_ASSOC);
                        // Check if bookings exist
                        if (empty($bookings)) {
                        ?>
                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td class="text-center">No Bookings Found</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                        <?php
                        }
                        $i = 0;
                        foreach ($bookings as $booking) {
                            $sql3 = "SELECT * FROM booking_direct_bill WHERE bookings_id = " . $booking['id'] . "";
                            $stmt3 = $conn->prepare($sql3);
                            $stmt3->execute();
                            $booking_bill = $stmt3->fetch(PDO::FETCH_ASSOC);
                            $formattedDate = date("d-m-Y", strtotime($booking['date']));
                        ?>
                            <tr>
                                <td><?= ++$i ?></td>
                                <td><?= $booking['order_id'] ?></td>
                                <td><?= $formattedDate ?></td>
                                <td><?= $booking['package_name'] ?></td>
                                <td><?= $booking['c_name'] . '(' . $booking['customer_id'] . ')<br>' . $booking['phone'] . '<br>' . $booking['email'] ?></td>

                                <?php
                                $ta_id = $booking['ta_id']; // Get the agency ID from booking

                                // Retrieve travel agency details safely
                                $agency_info = isset($ta_details[$ta_id]) ? $ta_details[$ta_id] : ['firstname' => '', 'lastname' => '', 'email' => '', 'phone' => ''];
                                ?>
                                <td><?= $agency_info['firstname'] . ' ' . $agency_info['lastname'] . '<br>' . $agency_info['phone'] . '<br>' . $agency_info['email'] ?></td>
                                <?php
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
                                    $load_modal = '';
                                    $border = 'border-primary';
                                    $bg_color = '';
                                    $cursor = '';
                                }
                                ?>


                                <?php
                                    $data_remaining_amt = '';
                                    $data_pending_amt = '';

                                    if ($perecent_fill == 40) {
                                        $data_remaining_amt = $booking_bill['part_pay_2'] + $booking_bill['part_pay_3'];
                                        $data_pending_amt = $booking_bill['part_pay_2'];
                                    } else if ($perecent_fill == 70) {
                                        $data_remaining_amt = $booking_bill['part_pay_3'];
                                        $data_pending_amt = $booking_bill['part_pay_3'];
                                    } else if ($perecent_fill == 50) {
                                        $data_remaining_amt = $booking_bill['part_pay_2'];
                                        $data_pending_amt = $booking_bill['part_pay_2'];
                                    }
                                ?>

                                <td>
                                    <div class="progress border <?= $border ?>" role="progressbar" aria-label="Example with label"
                                        aria-valuenow="<?= $perecent_fill ?>" aria-valuemin="0" aria-valuemax="100"
                                        <?= $load_modal ?> data-bs-target="#paymentModal"
                                        data-booking-id="<?= $booking['id'] ?>"
                                        data-booking-fullamt="<?= $booking_full_amt ?>"
                                        data-booking-paytype="<?= $booking_bill['pay_type'] ?>"
                                        data-booking-fill="<?= $perecent_fill ?>"
                                        <?= $data_remaining_amt !== '' ? 'data-remaining-amt="' . $data_remaining_amt . '"' : '' ?>
                                        <?= $data_pending_amt !== '' ? 'data-pending-amt="' . $data_pending_amt . '"' : '' ?>
                                    >
                                        <div class="progress-bar <?= $bg_color ?>" style="width: <?= $perecent_fill ?>%; height:10px; <?= $cursor ?>">
                                            <?= $perecent_fill ?>%
                                        </div>
                                    </div>
                                    <div class="my-2 text-center">Paid Rs.<?= $booking_paid_amt ?> of Rs.<?= $booking_full_amt ?></div>
                                </td>
                                <td>
                                    <div class="d-block">
                                        <a href="#">
                                            <button type="button" class="btn text-secondary-emphasis bg-secondary-subtle border border-secondary-subtle rounded-3 fw-bolder">Refunded</button>
                                        </a>
                                    </div>
                                <td class="text-center">
                                    <div class="dropdown mt-">
                                        <a class="" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false"><i class="fa solid fa-ellipsis pe-3" style="color: grey;"></i></a>
                                        <div class="dropdown-menu" id="dr-users" aria-labelledby="dropdownMenuButton">
                                            <a class="dropdown-item" href="order_details.php?id=<?= urlencode($booking["id"]) ?>"><i class="fa-solid fa-eye"></i> View</a>
                                            <a class="dropdown-item" href="dowload_pack_details.php?id=<?= urldecode($booking["package_id"]) ?>" id="generatePDF"><i class="fa-solid fa-arrow-down"></i> Download Details</a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
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
    <!-- confirm booking -->
     <div class="modal fade" id="confirmStatusModal" tabindex="-1" aria-labelledby="confirmStatusModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            
            <!-- Modal Header -->
            <div class="modal-header">
                <input type="hidden" id="modalOrderId" value="">
                <h5 class="modal-title" id="confirmStatusModalLabel">Confirm Status</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <!-- Modal Body -->
            <div class="modal-body">
                Are you sure you want to change the status?
            </div>

            <!-- Modal Footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" id="cancelBtn" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="confirmBtn">Confirm</button>
            </div>

            </div>
        </div>
    </div>

    <!-- end confirm booking -->
</div>
<!-- Responsive examples -->
<script src="../assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
<script src="../assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js"></script>
<script>
    // Prevent redeclaration
    if (typeof currentOrderId === 'undefined') {
        var currentOrderId = null;
    }

    // When modal is opened
    $(".open-status-modal").on("click", function () {
        currentOrderId = $(this).data("border-id");
        console.log('order_id:'+currentOrderId);
        
        $("#modalOrderId").val(currentOrderId);
    });

    function sendStatus(status) {
        const orderId = $("#modalOrderId").val();

        $.ajax({
            url: "confirm_status.php",
            method: "POST",
            data: {
                order_id: orderId,
                status: status
            },
            dataType: "json", // Expect JSON
            success: function (response) {
                console.log("Server Response:", response);

                if (response.success) {
                    alert(response.message);
                } else {
                    alert("Error: " + response.message);
                }

                const modal = bootstrap.Modal.getInstance(document.getElementById('confirmStatusModal'));
                modal.hide();
            },
            error: function (xhr, status, error) {
                console.error("AJAX Error:", status, error);
                alert("Something went wrong!");
            }
        });
    }


    // Confirm button click
    $("#confirmBtn").on("click", function () {
        sendStatus("confirm");
    });

    // Cancel button click
    $("#cancelBtn").on("click", function () {
        sendStatus("cancel");
    });

    $("#user_table1").DataTable();
    $("#user_table2").DataTable();
    $("#user_table3").DataTable();
    $("#user_table4").DataTable();
    $("#user_table5").DataTable();
</script>