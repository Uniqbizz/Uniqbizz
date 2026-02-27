<?php
    $sql = "SELECT * FROM `ca_cu_payout`  ORDER BY `ca_cu_payout`.`id` DESC";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    if ($stmt->rowCount() > 0) {
        foreach (($stmt->fetchALL()) as $key => $row) {

            // date in proper formate
            $dt = new DateTime($row['created_date']);
            $dt = $dt->format('Y-m-d');

            // Message statements for All payout
            // BDM No require for Customer Payout
            // replace dot at end of the line with break statement 
            $message1 = $row['message_bdm'];
            $message1 =  str_replace('.', '<br>', $message1);

            // replace dot at end of the line with break statement
            $message2 = $row['message_bm'];
            $message2 =  str_replace('.', '<br>', $message2);

            // replace dot at end of the line with break statement
            $message3 = $row['message_te'];
            $message3 =  str_replace('.', '<br>', $message3);

            // replace dot at end of the line with break statement
            $message4 = $row['message_tc'];
            $message4 =  str_replace('.', '<br>', $message4);

            // Amount Calcualtion with TDS
            // total Amt Cal for BM 
            $CommAmtBm = $row['commision_bm'] ? $row['commision_bm'] : 0;
            $tdsBm = $CommAmtBm * $tdsPer;
            $totalAmtBm = $CommAmtBm - $tdsBm;

            // total Amt Cal for TE
            $CommAmtTe = $row['commision_te'] ? $row['commision_te'] : 0;
            $tdsTe = $CommAmtTe * $tdsPer;
            $totalAmtTe = $CommAmtTe - $tdsTe;

            // total Amt Cal for TC
            $CommAmtTc = $row['commision_tc'] ? $row['commision_tc'] : 0;
            $tdsTc = $CommAmtTc * $tdsPer;
            $totalAmtTc = $CommAmtTc - $tdsTc;
            $user_desig='';
            
            //BM
            if (!$row['business_mentor'] == "") {
                //to get the prefix charater before first -
                preg_match('/^(.*?)\s*-\s*/', $message2, $match);

                if (!empty($match[1])) {
                    $user_desig=trim($match[1]); // Output only the text before the first dash
                } 
                ///-------
                echo '<tr>
                                <td class="d-none">' . $row['id'] . '</td>
                                <td>' . $dt . '</td>
                                <td>' . $message2 . '</td>
                                <td class="text-end">' . $CommAmtBm . '</td>
                                <td class="text-end">' . $tdsBm . '</td>
                                <td class="text-end">' . $totalAmtBm . '
                                    <a href="../../controllers/payout/forms/customer_recruitment_payout/download_cu_payout.php?vkvbvjfgfikix=' . $row['id'] . '&bm=' . $row['business_mentor'] . '&te=' . $row['techno_enterprise'] . '&tc=' . $row['travel_consultant'] . '&cu=' . $row['customer'] . '&date=' . $dt . '&message=' . $message2 . '&message_status=' . $row['status_bm'] . '&commission=' . $row['commision_bm'] . '&user_desig='.$user_desig.'">
                                        <i class="bx bx-download" style="font-size: 18px; color: black; padding-left: 5px;"></i>
                                    </a>
                                </td>';
                if ($row['status_bm'] == '1') {
                    echo '<td><span class="badge badge-pill badge-soft-success font-size-10 fw-bold ms-4">Paid</span></td>';
                } else {
                    echo '<td><span class="badge badge-pill badge-soft-warning font-size-10 fw-bold ms-4" data-bs-toggle="modal" data-bs-target=".bs-example-modal-center" onclick=\'paymentId("' . $row["id"] . '","' . $row['business_mentor'] . '","' . $row["message_bm"] . '","' . $CommAmtBm . '","' . $row["status_bm"] . '","messageBM")\'>Pending</span></td>';
                }
                echo '</tr>';
            }

            //TE
            if (!$row['techno_enterprise'] == "") {
                //to get the prefix charater before first -
                preg_match('/^(.*?)\s*-\s*/', $message3, $match);

                if (!empty($match[1])) {
                    $user_desig=trim($match[1]); // Output only the text before the first dash
                } 
                ///-------
                echo '<tr>
                                <td class="d-none">' . $row['id'] . '</td>
                                <td>' . $dt . '</td>
                                <td>' . $message3 . '</td>
                                <td class="text-end">' . $CommAmtTe . '</td>
                                <td class="text-end">' . $tdsTe . '</td>
                                <td class="text-end">' . $totalAmtTe . '
                                    <a href="forms/customer_recruitment_payout/download_cu_payout.php?vkvbvjfgfikix=' . $row['id'] . '&bm=' . $row['business_mentor'] . '&te=' . $row['techno_enterprise'] . '&tc=' . $row['travel_consultant'] . '&cu=' . $row['customer'] . '&date=' . $dt . '&message=' . $message3 . '&message_status=' . $row['status_te'] . '&commission=' . $row['commision_te'] . '&user_desig='.$user_desig.'">
                                        <i class="bx bx-download" style="font-size: 18px; color: black; padding-left: 5px;"></i>
                                    </a>
                                </td>';
                if ($row['status_te'] == '1') {
                    echo '<td><span class="badge badge-pill badge-soft-success font-size-10 fw-bold ms-4">Paid</span></td>';
                } else {
                    echo '<td><span class="badge badge-pill badge-soft-warning font-size-10 fw-bold ms-4" data-bs-toggle="modal" data-bs-target=".bs-example-modal-center" onclick=\'paymentId("' . $row["id"] . '","' . $row["techno_enterprise"] . '","' . $row["message_te"] . '","' . $CommAmtTe . '","' . $row["status_te"] . '","messageTE")\'>Pending</span></td>';
                }
                echo '</tr>';
            }

            //TC
            if (!$row['travel_consultant'] == "") {
                //to get the prefix charater before first -
                preg_match('/^(.*?)\s*-\s*/', $message4, $match);

                if (!empty($match[1])) {
                    $user_desig=trim($match[1]); // Output only the text before the first dash
                } 
                ///-------
                echo '<tr>
                                <td class="d-none">' . $row['id'] . '</td>
                                <td>' . $dt . '</td>
                                <td>' . $message4 . '</td>
                                <td class="text-end">' . $CommAmtTc . '</td>
                                <td class="text-end">' . $tdsTc . '</td>
                                <td class="text-end">' . $totalAmtTc . '
                                    <a href="forms/customer_recruitment_payout/download_cu_payout.php?vkvbvjfgfikix=' . $row['id'] . '&bm=' . $row['business_mentor'] . '&te=' . $row['techno_enterprise'] . '&tc=' . $row['travel_consultant'] . '&cu=' . $row['customer'] . '&date=' . $dt . '&message=' . $message4 . '&message_status=' . $row['status_tc'] . '&commission=' . $row['commision_tc'] . '&user_desig='.$user_desig.'">
                                        <i class="bx bx-download" style="font-size: 18px; color: black; padding-left: 5px;"></i>
                                    </a>
                                </td>';
                if ($row['status_tc'] == '1') {
                    echo '<td><span class="badge badge-pill badge-soft-success font-size-10 fw-bold ms-4">Paid</span></td>';
                } else {
                    echo '<td><span class="badge badge-pill badge-soft-warning font-size-10 fw-bold ms-4" data-bs-toggle="modal" data-bs-target=".bs-example-modal-center" onclick=\'paymentId("' . $row["id"] . '","' . $row["travel_consultant"] . '","' . $row["message_tc"] . '","' . $CommAmtTc . '","' . $row["status_tc"] . '","messageTC")\'>Pending</span></td>';
                }
                echo '</tr>';
            }
        }
    }
?>