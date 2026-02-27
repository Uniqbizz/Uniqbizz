<?php
    $sql = "SELECT * FROM `bcm_payout_history` WHERE  bcm_user_id = '" . $userId . "'  ";
    $stmt = $conn->prepare($sql);
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
            // Get Active BDMs
            $ids = json_decode($row['bdm_user_id'], true);
            $names = [];

            if (!empty($ids)) {
                $placeholders = rtrim(str_repeat('?,', count($ids)), ','); // ?,?,?
                $query = $conn->prepare("SELECT employee_id,  name FROM employees WHERE employee_id IN ($placeholders) AND user_type = 25 AND status = 1");
                $query->execute($ids);

                while ($bmRow = $query->fetch(PDO::FETCH_ASSOC)) {
                    $names[] = $bmRow['name'] . " (" . $bmRow['employee_id'] . ")";
                }
            }

            // Append Active BDMs to message
            $message1 = $row['message_bcm'];
            if (!empty($names)) {
                $message1 .= " Active BDMs: " . implode(', ', $names) . ".";
            }

            // replace dot at end of the line with break statement
            //$message1 = $row['message_bcm'];
            //$message1 =  str_replace('.', '<br>', $message1);

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
                                <a href="../controllers/payout/forms/slab_payout_bdm/download_ca_payout.php?vkvbvjfgfikix=' . $row['id'] . '&bc=' . $row['bcm_user_id'] . '&ca=' . urlencode(implode(', ', json_decode($row['bdm_user_id'], true))) .  '&date=' . $dt . '&message=' . $message1 . '&message_status=' . $row['payout_status'] . '&commission=' . $row['payout_amount'] . '&userType=' . $userType . '">
                                    <i class="bx bx-download" style="font-size: 18px; color: black; padding-left: 5px;"></i>
                                </a>
                            </td>';
            if ($row['payout_status'] == '2') {
                echo '<td><span class="badge bg-success font-size-10 fw-bold ms-4">Paid</span></td>';
            } else if ($row['payout_status'] == '3') {
                echo '<td><span class="badge bg-danger font-size-10 fw-bold ms-4"
                data-bs-toggle="modal"  data-bs-target="#rejectTopup" onclick="loadRejectionReason(' . $row['id'] . ')"
                style="cursor: pointer";>Blocked</span></td>';
            } else {
                echo '<td><span class="badge bg-warning font-size-10 fw-bold ms-4">Pending</span></td>';
            }
            echo '</tr>';
        }
    }
?>