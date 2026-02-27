<tbody>
    <?php
    $customer_fil = '';
    //check which user logged in based on user type
    if ($userType == '24') {
        // BCM's lower hierarchy (all TA paths)
        $sql0 = "
            SELECT ca.ca_travelagency_id, ca.firstname, ca.lastname, ca.email, ca.contact_no
            FROM ca_travelagency ca
            INNER JOIN corporate_agency co 
                ON co.corporate_agency_id = ca.reference_no AND co.status = 1
            INNER JOIN business_mentor bm 
                ON bm.business_mentor_id = co.reference_no AND bm.status = 1
            INNER JOIN employees bdm 
                ON bdm.employee_id = bm.reference_no AND bdm.status = 1
            INNER JOIN employees bcm 
                ON bcm.employee_id = bdm.reporting_manager AND bcm.status = 1
            WHERE ca.status = 1 AND bcm.employee_id = :userId

            UNION

            SELECT ca.ca_travelagency_id, ca.firstname, ca.lastname, ca.email, ca.contact_no
            FROM ca_travelagency ca
            INNER JOIN business_mentor bm 
                ON bm.business_mentor_id = ca.reference_no AND bm.status = 1
            INNER JOIN employees bdm 
                ON bdm.employee_id = bm.reference_no AND bdm.status = 1
            INNER JOIN employees bcm 
                ON bcm.employee_id = bdm.reporting_manager AND bcm.status = 1
            WHERE ca.status = 1 AND bcm.employee_id = :userId

            UNION

            SELECT ca.ca_travelagency_id, ca.firstname, ca.lastname, ca.email, ca.contact_no
            FROM ca_travelagency ca
            INNER JOIN master_franchisee mf 
                ON mf.master_franchisee_id = ca.reference_no AND mf.status = 1
            INNER JOIN employees bdm 
                ON bdm.employee_id = mf.reference_no AND bdm.status = 1
            INNER JOIN employees bcm 
                ON bcm.employee_id = bdm.reporting_manager AND bcm.status = 1
            WHERE ca.status = 1 AND bcm.employee_id = :userId

            UNION

            SELECT ca.ca_travelagency_id, ca.firstname, ca.lastname, ca.email, ca.contact_no
            FROM ca_travelagency ca
            INNER JOIN sub_franchisee f 
                ON f.sub_franchisee_id = ca.reference_no AND f.status = 1
            INNER JOIN master_franchisee mf 
                ON mf.master_franchisee_id = f.reference_no AND mf.status = 1
            INNER JOIN employees bdm 
                ON bdm.employee_id = mf.reference_no AND bdm.status = 1
            INNER JOIN employees bcm 
                ON bcm.employee_id = bdm.reporting_manager AND bcm.status = 1
            WHERE ca.status = 1 AND bcm.employee_id = :userId

            UNION

            SELECT ca.ca_travelagency_id, ca.firstname, ca.lastname, ca.email, ca.contact_no
            FROM ca_travelagency ca
            INNER JOIN sub_franchisee f 
                ON f.sub_franchisee_id = ca.reference_no AND f.status = 1
            INNER JOIN sponsor_franchisee sf 
                ON sf.sponsor_franchisee_id = f.reference_no AND sf.status = 1
            INNER JOIN employees bdm 
                ON bdm.employee_id = sf.reference_no AND bdm.status = 1
            INNER JOIN employees bcm 
                ON bcm.employee_id = bdm.reporting_manager AND bcm.status = 1
            WHERE ca.status = 1 AND bcm.employee_id = :userId

            UNION

            SELECT ca.ca_travelagency_id, ca.firstname, ca.lastname, ca.email, ca.contact_no
            FROM ca_travelagency ca
            INNER JOIN employees bdm 
                ON bdm.employee_id = ca.reference_no AND bdm.status = 1
            INNER JOIN employees bcm 
                ON bcm.employee_id = bdm.reporting_manager AND bcm.status = 1
            WHERE ca.status = 1 AND bcm.employee_id = :userId
        ";

        $stmt0 = $conn->prepare($sql0);
        $stmt0->execute([':userId' => $userId]);
        $ta_list = $stmt0->fetchAll(PDO::FETCH_ASSOC);
    }
    else if ($userType == '25') {
        // BDM's lower hierarchy (all TA paths)
        $sql0 = "
            -- 1. BDM -> BM -> TE -> TC
            SELECT ca.ca_travelagency_id, ca.firstname, ca.lastname, ca.email, ca.contact_no
            FROM ca_travelagency ca
            INNER JOIN corporate_agency co 
                ON co.corporate_agency_id = ca.reference_no AND co.status = 1
            INNER JOIN business_mentor bm 
                ON bm.business_mentor_id = co.reference_no AND bm.status = 1
            INNER JOIN employees bdm 
                ON bdm.employee_id = bm.reference_no AND bdm.status = 1
            WHERE ca.status = 1 AND bdm.employee_id = :userId

            UNION

            -- 2. BDM -> BM -> TC
            SELECT ca.ca_travelagency_id, ca.firstname, ca.lastname, ca.email, ca.contact_no
            FROM ca_travelagency ca
            INNER JOIN business_mentor bm 
                ON bm.business_mentor_id = ca.reference_no AND bm.status = 1
            INNER JOIN employees bdm 
                ON bdm.employee_id = bm.reference_no AND bdm.status = 1
            WHERE ca.status = 1 AND bdm.employee_id = :userId

            UNION

            -- 3. BDM -> MF -> TC
            SELECT ca.ca_travelagency_id, ca.firstname, ca.lastname, ca.email, ca.contact_no
            FROM ca_travelagency ca
            INNER JOIN master_franchisee mf 
                ON mf.master_franchisee_id = ca.reference_no AND mf.status = 1
            INNER JOIN employees bdm 
                ON bdm.employee_id = mf.reference_no AND bdm.status = 1
            WHERE ca.status = 1 AND bdm.employee_id = :userId

            UNION

            -- 4. BDM -> MF -> F -> TC
            SELECT ca.ca_travelagency_id, ca.firstname, ca.lastname, ca.email, ca.contact_no
            FROM ca_travelagency ca
            INNER JOIN sub_franchisee f 
                ON f.sub_franchisee_id = ca.reference_no AND f.status = 1
            INNER JOIN master_franchisee mf 
                ON mf.master_franchisee_id = f.reference_no AND mf.status = 1
            INNER JOIN employees bdm 
                ON bdm.employee_id = mf.reference_no AND bdm.status = 1
            WHERE ca.status = 1 AND bdm.employee_id = :userId

            UNION

            -- 5. BDM -> SF -> F -> TC
            SELECT ca.ca_travelagency_id, ca.firstname, ca.lastname, ca.email, ca.contact_no
            FROM ca_travelagency ca
            INNER JOIN sub_franchisee f 
                ON f.sub_franchisee_id = ca.reference_no AND f.status = 1
            INNER JOIN sponsor_franchisee sf 
                ON sf.sponsor_franchisee_id = f.reference_no AND sf.status = 1
            INNER JOIN employees bdm 
                ON bdm.employee_id = sf.reference_no AND bdm.status = 1
            WHERE ca.status = 1 AND bdm.employee_id = :userId

            UNION

            -- 6. BDM -> TC (direct)
            SELECT ca.ca_travelagency_id, ca.firstname, ca.lastname, ca.email, ca.contact_no
            FROM ca_travelagency ca
            INNER JOIN employees bdm 
                ON bdm.employee_id = ca.reference_no AND bdm.status = 1
            WHERE ca.status = 1 AND bdm.employee_id = :userId
        ";

        $stmt0 = $conn->prepare($sql0);
        $stmt0->execute([':userId' => $userId]);
        $ta_list = $stmt0->fetchAll(PDO::FETCH_ASSOC);
    }
    else if ($userType == '26') {
        // BM and lower hierarchy (all TA paths under BM)
        $sql0 = "
            -- 1. BM -> TE -> TC
            SELECT ca.ca_travelagency_id, ca.firstname, ca.lastname, ca.email, ca.contact_no
            FROM ca_travelagency ca
            INNER JOIN corporate_agency co 
                ON co.corporate_agency_id = ca.reference_no AND co.status = 1
            INNER JOIN business_mentor bm 
                ON co.reference_no = bm.business_mentor_id AND bm.status = 1
            WHERE ca.status = 1 AND bm.business_mentor_id = :userId

            UNION

            -- 2. BM -> TC (direct)
            SELECT ca.ca_travelagency_id, ca.firstname, ca.lastname, ca.email, ca.contact_no
            FROM ca_travelagency ca
            INNER JOIN business_mentor bm 
                ON bm.business_mentor_id = ca.reference_no AND bm.status = 1
            WHERE ca.status = 1 AND bm.business_mentor_id = :userId
        ";

        $stmt0 = $conn->prepare($sql0);
        $stmt0->execute([':userId' => $userId]);
        $ta_list = $stmt0->fetchAll(PDO::FETCH_ASSOC);
    }
    else if ($userType == '28') {
        // MF and lower hierarchy (all TA paths under MF)
        $sql0 = "
            -- 1. MF -> F -> TC -> TA
            SELECT ca.ca_travelagency_id, ca.firstname, ca.lastname, ca.email, ca.contact_no
            FROM ca_travelagency ca
            INNER JOIN corporate_agency co 
                ON co.corporate_agency_id = ca.reference_no AND co.status = 1
            INNER JOIN sub_franchisee f 
                ON f.sub_franchisee_id = co.reference_no AND f.status = 1
            INNER JOIN employees mf
                ON mf.employee_id = f.reference_no AND mf.status = 1
            WHERE ca.status = 1 AND mf.employee_id = :userId

            UNION

            -- 2. MF -> TC -> TA (direct under MF)
            SELECT ca.ca_travelagency_id, ca.firstname, ca.lastname, ca.email, ca.contact_no
            FROM ca_travelagency ca
            INNER JOIN sub_franchisee f 
                ON f.sub_franchisee_id = ca.reference_no AND f.status = 1
            INNER JOIN employees mf
                ON mf.employee_id = f.reference_no AND mf.status = 1
            WHERE ca.status = 1 AND mf.employee_id = :userId
        ";

        $stmt0 = $conn->prepare($sql0);
        $stmt0->execute([':userId' => $userId]);
        $ta_list = $stmt0->fetchAll(PDO::FETCH_ASSOC);
    }
    else if ($userType == '30') {
        // SF and lower hierarchy (all TA paths under SF)
        $sql0 = "
            -- 1. SF -> F -> TC -> TA
            SELECT ca.ca_travelagency_id, ca.firstname, ca.lastname, ca.email, ca.contact_no
            FROM ca_travelagency ca
            INNER JOIN corporate_agency co 
                ON co.corporate_agency_id = ca.reference_no AND co.status = 1
            INNER JOIN sub_franchisee f 
                ON f.sub_franchisee_id = co.reference_no AND f.status = 1
            INNER JOIN employees sf
                ON sf.employee_id = f.reference_no AND sf.status = 1
            WHERE ca.status = 1 AND sf.employee_id = :userId

            UNION

            -- 2. SF -> TC -> TA (direct under SF)
            SELECT ca.ca_travelagency_id, ca.firstname, ca.lastname, ca.email, ca.contact_no
            FROM ca_travelagency ca
            INNER JOIN sub_franchisee f 
                ON f.sub_franchisee_id = ca.reference_no AND f.status = 1
            INNER JOIN employees sf
                ON sf.employee_id = f.reference_no AND sf.status = 1
            WHERE ca.status = 1 AND sf.employee_id = :userId
        ";

        $stmt0 = $conn->prepare($sql0);
        $stmt0->execute([':userId' => $userId]);
        $ta_list = $stmt0->fetchAll(PDO::FETCH_ASSOC);
    }
    else if ($userType == '16') {
        //TE and lower hirachy
        $sql0 = "SELECT ca_travelagency.ca_travelagency_id, ca_travelagency.firstname, ca_travelagency.lastname, ca_travelagency.email, ca_travelagency.contact_no FROM ca_travelagency
            INNER join corporate_agency on corporate_agency.corporate_agency_id = ca_travelagency.reference_no and corporate_agency.status=1                                                        
            WHERE ca_travelagency.status=1 and corporate_agency.corporate_agency_id='" . $userId . "'";
        $stmt0 = $conn->prepare($sql0);
        $stmt0->execute();
        $ta_list = $stmt0->fetchAll(PDO::FETCH_ASSOC); // Fetch as associative array
    } 
    else if ($userType == '29') {
        // Franchisee (F) and lower hierarchy (all TA under F)
        $sql0 = "
            SELECT ca.ca_travelagency_id, ca.firstname, ca.lastname, ca.email, ca.contact_no
            FROM ca_travelagency ca
            INNER JOIN sub_franchisee f 
                ON f.sub_franchisee_id = ca.reference_no AND f.status = 1
            WHERE ca.status = 1 AND f.sub_franchisee_id = :userId
        ";

        $stmt0 = $conn->prepare($sql0);
        $stmt0->execute([':userId' => $userId]);
        $ta_list = $stmt0->fetchAll(PDO::FETCH_ASSOC); // Fetch as associative array
    }
    else if ($userType == '11') {
        //TC
        $sql0 = "SELECT ca_travelagency.ca_travelagency_id, ca_travelagency.firstname, ca_travelagency.lastname, ca_travelagency.email, ca_travelagency.contact_no FROM ca_travelagency                                                        
            WHERE ca_travelagency.status=1 and ca_travelagency_id='" . $userId . "'";
        $stmt0 = $conn->prepare($sql0);
        $stmt0->execute();
        $ta_list = $stmt0->fetchAll(PDO::FETCH_ASSOC); // Fetch as associative array
    } else if ($userType == '10') {
        //Customer
        $sql0 = "SELECT ca_travelagency.ca_travelagency_id, ca_travelagency.firstname, ca_travelagency.lastname, ca_travelagency.email, ca_travelagency.contact_no FROM ca_travelagency 
            INNER JOIN ca_customer on ca_customer.ta_reference_no = ca_travelagency.ca_travelagency_id and ca_customer.status=1
            WHERE ca_travelagency.status=1 and ca_customer.ca_customer_id='" . $userId . "'";
        $stmt0 = $conn->prepare($sql0);
        $stmt0->execute();
        $ta_list = $stmt0->fetchAll(PDO::FETCH_ASSOC); // Fetch as associative array
        $customer_fil = " AND b.customer_id='" . $userId . "'";
    }
    else if ($userType == '31') {
        // BDM's lower hierarchy (all TA paths)
        $sql0 = "
            -- 1. RM -> MF -> TC
            SELECT ca.ca_travelagency_id, ca.firstname, ca.lastname, ca.email, ca.contact_no
            FROM ca_travelagency ca
            INNER JOIN master_franchisee mf 
                ON mf.master_franchisee_id = ca.reference_no AND mf.status = 1
            INNER JOIN employees bdm 
                ON bdm.employee_id = mf.reference_no AND bdm.status = 1
            WHERE ca.status = 1 AND bdm.employee_id = :userId

            UNION

            -- 2. RM -> MF -> F -> TC
            SELECT ca.ca_travelagency_id, ca.firstname, ca.lastname, ca.email, ca.contact_no
            FROM ca_travelagency ca
            INNER JOIN sub_franchisee f 
                ON f.sub_franchisee_id = ca.reference_no AND f.status = 1
            INNER JOIN master_franchisee mf 
                ON mf.master_franchisee_id = f.reference_no AND mf.status = 1
            INNER JOIN employees bdm 
                ON bdm.employee_id = mf.reference_no AND bdm.status = 1
            WHERE ca.status = 1 AND bdm.employee_id = :userId

            UNION

            -- 3. RM -> SF -> F -> TC
            SELECT ca.ca_travelagency_id, ca.firstname, ca.lastname, ca.email, ca.contact_no
            FROM ca_travelagency ca
            INNER JOIN sub_franchisee f 
                ON f.sub_franchisee_id = ca.reference_no AND f.status = 1
            INNER JOIN sponsor_franchisee sf 
                ON sf.sponsor_franchisee_id = f.reference_no AND sf.status = 1
            INNER JOIN employees bdm 
                ON bdm.employee_id = sf.reference_no AND bdm.status = 1
            WHERE ca.status = 1 AND bdm.employee_id = :userId

            UNION

            -- 4. M -> TC (direct)
            SELECT ca.ca_travelagency_id, ca.firstname, ca.lastname, ca.email, ca.contact_no
            FROM ca_travelagency ca
            INNER JOIN employees bdm 
                ON bdm.employee_id = ca.reference_no AND bdm.status = 1
            WHERE ca.status = 1 AND bdm.employee_id = :userId
        ";

        $stmt0 = $conn->prepare($sql0);
        $stmt0->execute([':userId' => $userId]);
        $ta_list = $stmt0->fetchAll(PDO::FETCH_ASSOC);
    }
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