<?php
    $stmt = $conn->prepare("SELECT * FROM `customer_reference_payout` WHERE customer_id = '" . $userId . "' AND booking_points IS NOT NULL ORDER BY ID DESC");
    $stmt->execute();
    $referrals = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $i = 0;
    
    if (!empty($referrals)) {

        foreach ($referrals as $referral) {
            $referral_text = $referral['booking_message']; // Original string
            $formatted_date = date('d-m-Y', strtotime($referral['created_date']));
            $formatted_text = '';

            $split = explode('points', $referral_text, 2);
            if (count($split) == 2) {
                $first_part = trim($split[0]) . ' points'; // e.g. "Harsh... 500 booking points"
                $after_points = trim($split[1]); // e.g. "as a Level 1 referrer for referring Tukaram..."

                // Check for "through"
                if (stripos($after_points, 'through') !== false) {
                    $through_split = explode('through', $after_points, 2);
                    $before_through = trim($through_split[0]); // e.g. "as a Level 2 referrer for referring Brijesh..."
                    $through_clause = 'through ' . trim($through_split[1]);
                    $formatted_text = $first_part . '<br>' . $before_through . '<br>' . $through_clause;
                } else {
                    $formatted_text = $first_part . '<br>' . $after_points;
                }
            } else {
                $formatted_text = $referral_text;
            }
            echo '<tr>
            <td>' . ++$i . '</td>
            <td>' . $formatted_text.'</td>
            <td>' . $referral['booking_points'] . '</td>
            <td>' . $formatted_date . '</td>';
            if ($referral['status'] == '3')
                echo '<td><span class="badge bg-success">Credited</span></td>';
        }
    }
?>