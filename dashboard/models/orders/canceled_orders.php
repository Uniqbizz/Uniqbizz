<tbody>
    <?php
        $customer_fil = '';
        //check which user logged in based on user type
        //data load from models file
        include 'all_channels.php';

        // Check if travel agencies exist
        if (empty($ta_list)) {
            echo '<tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td class="text-center">No Travel Agencies Found</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>';
            // exit; // Stop further execution
        } else {

            // Create an array mapping travel agency IDs to their details
            $ta_details = [];
            $ta_ids = [];

            foreach ($ta_list as $ta) {
                $ta_ids[] = $ta['tc_id']; // Collecting IDs for SQL query
                $ta_details[$ta['tc_id']] = [
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
                            WHERE b.ta_id IN ($ta_ids_str) AND b.status='2' $customer_fil"; // Use IN clause to match multiple IDs
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
        } else {
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
                            $booking_full_amt = $booking_bill['total_net_payable'];
                        } elseif ($booking_bill['part_pay_1_status'] == 1 && $booking_bill['part_pay_2_status'] == 1) {
                            # code...
                            $perecent_fill = 100;
                            $booking_paid_amt = $booking_bill['part_pay_1'] + $booking_bill['part_pay_2'];
                            $booking_full_amt = $booking_bill['total_net_payable'];
                        }
                    } else if ($booking_bill['pay_type'] == 3) {
                        # code...
                        if ($booking_bill['part_pay_1_status'] == 1 && $booking_bill['part_pay_2_status'] == 0 && $booking_bill['part_pay_3_status'] == 0) {
                            # code...
                            $perecent_fill = 40;
                            $booking_paid_amt = $booking_bill['part_pay_1'];
                            $booking_full_amt = $booking_bill['total_net_payable'];
                        } elseif ($booking_bill['part_pay_1_status'] == 1 && $booking_bill['part_pay_2_status'] == 1 && $booking_bill['part_pay_3_status'] == 0) {
                            # code...
                            $perecent_fill = 70;
                            $booking_paid_amt = $booking_bill['part_pay_1'] + $booking_bill['part_pay_2'];
                            $booking_full_amt = $booking_bill['total_net_payable'];
                        } elseif ($booking_bill['part_pay_1_status'] == 1 && $booking_bill['part_pay_1_status'] == 1 && $booking_bill['part_pay_3_status'] == 1) {
                            # code...
                            $perecent_fill = 100;
                            $booking_paid_amt = $booking_bill['part_pay_1'] + $booking_bill['part_pay_2'] + $booking_bill['part_pay_3'];
                            $booking_full_amt = $booking_bill['total_net_payable'];
                        }
                    } else {
                        $perecent_fill = 100;
                        $booking_paid_amt = $booking_bill['amount'];
                        $booking_full_amt = $booking_bill['total_net_payable'];
                    }

                    if ($perecent_fill == 100) {
                        $load_modal = '';
                        $border = 'border-success';
                        $bg_color = 'bg-success';
                        $cursor = '';
                    } else {
                        $load_modal = $userType == '11' ? 'data-bs-toggle="modal"' : '';
                        $border = 'border-primary';
                        $bg_color = '';
                        $cursor = 'cursor: pointer';
                    }
                    ?>
                    <td>
                        <div class="progress border  <?= $border ?>" role="progressbar" aria-label="Example with label" aria-valuenow="<?= $perecent_fill ?>" aria-valuemin="0" aria-valuemax="100" <?= $load_modal ?> data-bs-target="#paymentModal" data-booking-id="<?= $booking['id'] ?>" data-booking-fullamt="<?= $booking_full_amt ?>" data-booking-paytype="<?= $booking_bill['pay_type'] ?>" data-booking-fill="<?= $perecent_fill ?>"
                            <?php
                            if ($perecent_fill == 40) {
                                echo ' data-remaining-amt="' . $booking_bill['part_pay_2'] + $booking_bill['part_pay_3'] . '" data-pending-amt="' . $booking_bill['part_pay_2'] . '"';
                            } else if ($perecent_fill == 70) {
                                echo ' data-remaining-amt="' . $booking_bill['part_pay_3'] . '"data-pending-amt="' . $booking_bill['part_pay_3'] . '"';
                            } else if ($perecent_fill == 50) {
                                echo ' data-remaining-amt="' . $booking_bill['part_pay_2'] . '" data-pending-amt="' . $booking_bill['part_pay_2'] . '"';
                            }
                            ?>>
                            <div class="progress-bar <?= $bg_color . '" style="width: ' . $perecent_fill . '%; height:10px; ' . $cursor ?>"><?= $perecent_fill ?>%</div>
                        </div>
                        <div id="" class="my-2 text-center">Paid Rs.<? $booking_paid_amt . ' of Rs.' . $booking_full_amt ?></div>
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
                                <a class="dropdown-item" href="../controllers/orders/dowload_pack_details.php?id=<?= urldecode($booking["package_id"]) ?>" id="generatePDF"><i class="fa-solid fa-arrow-down"></i> Download Itineraries</a>
                                <a class="dropdown-item refundAction" href="#" data-order-id=<?= $booking["id"] ?>><i class="fa-solid fa-money-bill-transfer"></i> Initiate Refund</a>
                            </div>
                        </div>
                    </td>
                </tr>
    <?php
            }
        }
    } ?>
</tbody>