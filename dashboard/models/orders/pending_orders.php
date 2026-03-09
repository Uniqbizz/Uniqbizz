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

        // Travel Agency Mapping
        $ta_details = [];
        $ta_ids = [];
        foreach ($ta_list as $ta) {
            $ta_ids[] = $ta['tc_id'];
            $ta_details[$ta['tc_id']] = [
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
                    WHERE b.ta_id IN ($ta_ids_str) AND b.status != '2' AND b.status != '3'AND b.confirm_status=0 $customer_fil
                    ";

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
            <?php } else {
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
                        $final_price = $booking_bill['total_net_payable'];

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
                            aria-valuenow="<?= $perecent_fill ?>" aria-valuemin="0" aria-valuemax="100">
                            <div class="progress-bar <?= ($perecent_fill == 100 ? 'bg-success' : '') ?>" style="width: <?= $perecent_fill ?>%;">
                                <?= $perecent_fill ?>%
                            </div>
                        </div>
                        <div class="my-2 text-center">Paid Rs.<?= $booking_paid_amt . ' of Rs.' . $booking_full_amt ?></div>
                    </td>

                    <?php if ($booking['confirm_status'] == 0) { ?>
                    <td>
                        <div class="d-block">
                            <a href="#">
                                <button type="button" class="btn text-info-emphasis bg-info-subtle border border-info-subtle rounded-3 fw-bolder">Pending</button>
                            </a>
                        </div>
                    </td>
                    <?php } ?>

                    <td class="text-center">
                        <div class="dropdown mt-">
                            <a class="" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false"><i class="fa solid fa-ellipsis pe-3" style="color: grey;"></i></a>
                            <div class="dropdown-menu" id="dr-users" aria-labelledby="dropdownMenuButton">
                                <a class="dropdown-item" href="order_details.php?id=<?= urlencode($booking["id"]) ?>"><i class="fa-solid fa-eye"></i> View</a>
                                <a class="dropdown-item" href="../controllers/orders/dowload_pack_details.php?id=<?= urldecode($booking["package_id"]) ?>" id="generatePDF"><i class="fa-solid fa-arrow-down"></i> Download Itineraries</a>
                            </div>
                        </div>
                    </td>
                </tr>
    <?php  }
        }
    } ?>
</tbody>