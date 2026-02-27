<?php
    $stmt = $conn->prepare("SELECT * FROM `ta_top_up_payment` WHERE ta_id = '" . $userId . "' ORDER BY ID DESC");
    $stmt->execute();
    $referrals = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $i = 0;
    foreach ($referrals as $referral) {
        echo '<tr>
        <td>' . ++$i . '</td>
        <td>' . $referral['top_up_amt'] . '</td>
        <td>' . $referral['created_date'] . '</td>
        <td>' . $referral['updated_date'] . '</td>';
        if ($referral['status'] == '1')
            echo '<td><span class="badge bg-warning">Pending</span></td>';
        else if ($referral['status'] == '2')
            echo '<td><span class="badge bg-success">Approved</span></td>';
        else if ($referral['status'] == '3')
            echo '<td><span class="badge bg-danger rejectMess" data-created-date="'. $referral['created_date'] .'" data-user-id="'. $userId .'" style="cursor:pointer">Rejected</span></td>';

        echo '</tr>';
    }
?>