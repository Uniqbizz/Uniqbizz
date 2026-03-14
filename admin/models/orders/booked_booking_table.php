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
            require '../../connect.php';

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
                        WHERE b.ta_id IN ($ta_ids_str) AND b.status='1'"; // Use IN clause to match multiple IDs
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
                        $booking_full_amt = $booking_bill['total_net_payable'];
                    }
                } else if ($booking_bill['pay_type'] == 3) {
                    if ($booking_bill['part_pay_1_status'] == 1 && $booking_bill['part_pay_2_status'] == 0 && $booking_bill['part_pay_3_status'] == 0) {
                        continue;
                    } elseif ($booking_bill['part_pay_1_status'] == 1 && $booking_bill['part_pay_2_status'] == 1 && $booking_bill['part_pay_3_status'] == 0) {
                        continue;
                    } elseif ($booking_bill['part_pay_1_status'] == 1 && $booking_bill['part_pay_2_status'] == 1 && $booking_bill['part_pay_3_status'] == 1) {
                        $perecent_fill = 100;
                        $booking_paid_amt = $booking_bill['part_pay_1'] + $booking_bill['part_pay_2'] + $booking_bill['part_pay_3'];
                        $booking_full_amt = $booking_bill['total_net_payable'];
                    }
                } else {
                    $perecent_fill = 100;
                    $booking_paid_amt = $booking_bill['amount'];
                    $booking_full_amt = $booking_bill['total_net_payable'];
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

                if ($booking['confirm_status'] == 1 && $today > $endDate) {
            ?>
            <td>
                <div class="d-block">
                    <a href="#">
                        <button type="button" class="btn text-info-emphasis bg-info-subtle border border-info-subtle rounded-3 fw-bolder">Completed</button>
                    </a>
                </div>
            </td>
            <?php } else if ($booking['confirm_status'] == 1 &&($today >= $startDate || $today <= $endDate)) { ?>
            <td>
                <div class="d-block">
                    <a href="#">
                        <button type="button" class="btn text-info-emphasis bg-info-subtle border border-info-subtle rounded-3 fw-bolder">Traveling</button>
                    </a>
                </div>
            </td>
            <?php } else { ?>
            <td>
                <div class="d-block">
                    <a href="#">
                        <button type="button" class="btn text-primary-emphasis bg-primary-subtle border border-primary-subtle rounded-3 fw-bolder">Confirmed</button>
                    </a>
                </div>
            </td>
            <?php } ?>

            <td class="text-center">
                <div class="dropdown mt-">
                    <a class="" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false"><i class="fa solid fa-ellipsis pe-3" style="color: grey;"></i></a>
                    <div class="dropdown-menu" id="dr-users" aria-labelledby="dropdownMenuButton">
                        <a class="dropdown-item" href="order_details.php?id=<?= urlencode($booking["id"]) ?>"><i class="fa-solid fa-eye"></i> View</a>
                        <a class="dropdown-item" href="dowload_pack_details.php?id=<?= urldecode($booking["package_id"]) ?>" id="generatePDF"><i class="fa-solid fa-arrow-down"></i> Download Itineraries</a>
                    </div>
                </div>
            </td>
        </tr>
        <?php } ?>
    </tbody>
</table>