<?php
    $stmt = $conn->prepare("SELECT * FROM `customer_reference_payout` WHERE customer_id = '" . $userId . "' AND referral_amount IS NOT NULL ORDER BY ID DESC");
    $stmt->execute();
    $referrals = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $i = 0;
    

    foreach ($referrals as $referral) {
        $referral_text = $referral['referral_message']; // Original string
        $formatted_date = date('d-m-Y', strtotime($referral['created_date']));
        $split = explode('referring', $referral_text, 2);
        $formatted_text = '';

        if (count($split) == 2) {
            $first_part = trim($split[0]) . ' referring';
            $after_referring = trim($split[1]);

            if (strpos($after_referring, 'through') !== false) {
                $split2 = explode('through', $after_referring, 2);
                $second_part = trim($split2[0]);
                $third_part = trim($split2[1]);
                $formatted_text = $first_part . '<br>' . $second_part . '<br>' . $third_part;
            } else {
                $second_part = $after_referring;
                $formatted_text = $first_part . '<br>' . $second_part;
            }
        } else {
            // If "referring" not found, use full text
            $formatted_text = $referral_text;
        }
        echo '<tr>
        <td>' . ++$i . '</td>
        <td>' . $formatted_text.'</td>
        <td>' . $referral['referral_amount'] . '</td>
        <td>' . $formatted_date . '</td>';
        if ($referral['status'] == '1')
            echo '<td><span class="badge bg-success">Paid</span></td>';
        else if ($referral['status'] == '2')
            echo '<td><span class="badge bg-warning">Pending</span></td>';
        echo '</tr>';
    }
?>