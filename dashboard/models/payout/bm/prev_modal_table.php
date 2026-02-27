<?php
    $sql2 = "SELECT * FROM bm_payout_history WHERE bm_user_id = '" . $userId . "' AND YEAR(payout_date) = '" . $prevDateYear . "' AND MONTH(payout_date) = '" . $prevDateMonth . "' ";
    $stmt = $conn->prepare($sql2);
    $stmt->execute();
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    if ($stmt->rowCount() > 0) {
        foreach (($stmt->fetchALL()) as $key => $row) {

            // date in proper formate 
            //if payout is paid/decline
            if ($row['payout_status'] == 2 || $row['payout_status'] == 3) {
                $dt = new DateTime($row['release_date']);
                $dt = $dt->format('Y-m-d');
            }
            //if payout is pending 
            else {
                $dt = new DateTime($row['payout_date']);
                $dt = $dt->format('Y-m-d');
            }


            // replace dot at end of the line with break statement
            $message1 = $row['message_bm'];
            //$message1 =  str_replace('.', '<br>', $message1);

            // total Amt Cal for BM 
            if ($row['payout_amount'] == "null") {
                $CommAmt = '0';
                $tds = '0';
                $totalAmt = '0';
            } else {
                $CommAmt = $row['payout_amount'];
                $tds = $CommAmt * $tds_percentage;
                $totalAmt = $CommAmt - $tds;
            }

            echo '<tr>
                <td>' . $dt . '</td>
                <td>' . $message1 . '</td>
                <td class="text-end">' . $CommAmt . '</td>
                <td class="text-end">' . $tds . '</td>
                <td class="text-end">' . $totalAmt . '
                    <a href="../controllers/payout/forms/slab_payout_forms/download_ca_payout.php?vkvbvjfgfikix=' . $row['id'] . '&bc=' . $row['bm_user_id'] . '&ca=' . $row['ca_user_id'] . '&date=' . $dt . '&message=' . $message1 . '&message_status=' . $row['payout_status'] . '&commission=' . $row['payout_amount'] . '">
                        <i class="bx bx-download" style="font-size: 18px; color: black; padding-left: 5px;"></i>
                    </a>
                </td>';
                if ($row['payout_status'] == '2') {
                    echo '<td><span class="badge bg-success font-size-10 fw-bold ms-4">Paid</span></td>';
                } else if ($row['payout_status'] == '3') {
                    echo '<td><span class="badge bg-danger font-size-10 fw-bold ms-4"
                    data-bs-toggle="modal" data-bs-target="#rejectTopup" onclick="loadRejectionReason(' . $row['id'] . ')" style="cursor: pointer";>Blocked</span></td>';
                } else {
                    echo '<td><span class="badge bg-warning font-size-10 fw-bold ms-4" data-bs-toggle="modal" data-bs-target=".bs-example-modal-center" onclick=\'paymentId("' . $row['id'] . '","' . $row['bm_user_id'] . '","' . $row['message_bm'] . '","' . $row['payout_amount'] . '","' . $row['payout_status'] . '","PrevPayout")\'>Pending</span></td>';
                }
            echo '</tr>';
        }
    }
?>