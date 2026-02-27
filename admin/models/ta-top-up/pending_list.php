<tbody>
    <?php
        require '../../connect.php';

        $stmt = $conn->prepare("SELECT ta_id,SUM(top_up_amt) AS total_pending_amt FROM `ta_top_up_payment` WHERE status = 1 GROUP BY ta_id ORDER BY ta_id DESC");
        $stmt->execute();
        $referrals = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        $stmt2 = $conn->prepare("SELECT DISTINCT  ta_id, ta_fname, ta_lname FROM `ta_top_up_payment` WHERE status = 1 ORDER BY ta_id DESC");
        $stmt2->execute();
        $referrals2 = $stmt2->fetchAll(PDO::FETCH_ASSOC);
        
        $j=0;
        // Create an associative array for fast lookup by ta_id from $referrals2
        $referrals2_lookup = [];
        foreach ($referrals2 as $row) {
            $referrals2_lookup[$row['ta_id']] = [
                'ta_fname' => $row['ta_fname'],
                'ta_lname' => $row['ta_lname']
            ];
        }
        
        // Merge ta_fname and ta_lname into the $referrals array based on ta_id
        foreach ($referrals as &$referral) {
            $ta_id = $referral['ta_id'];
            if (isset($referrals2_lookup[$ta_id])) {
                $referral['ta_fname'] = $referrals2_lookup[$ta_id]['ta_fname'];
                $referral['ta_lname'] = $referrals2_lookup[$ta_id]['ta_lname'];
            } else {
                // Optionally, set default values if no match is found
                $referral['ta_fname'] = 'Unknown';
                $referral['ta_lname'] = 'Unknown';
            }
        }
        
        foreach ($referrals as $referral): ?>
            <tr class="main-row" data-ta-id="<?= htmlspecialchars($referral['ta_id']) ?>">
                <td class="details-control">+</td>
                <td>
                    <?php
                        // Check if ta_fname and ta_lname exist before displaying them
                        $fullName = isset($referral['ta_fname']) && isset($referral['ta_lname']) ? 
                                    htmlspecialchars($referral['ta_fname'] . ' ' . $referral['ta_lname']) : 'Unknown';
                        echo $fullName;
                    ?>
                </td>
                <td><?= number_format($referral['total_pending_amt'], 2) ?></td>
                <td>
                    <div class="dropdown">
                        <a class="" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="mdi mdi-dots-horizontal mdi-24px" style="color: grey;"></i>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <a class="dropdown-item exportCSV" href="#" data-ta-id="<?= htmlspecialchars($referral['ta_id']) ?>">
                                <i class="bx bx-download"></i> Download
                            </a>
                        </div>
                    </div>
                </td>
            </tr>
    <?php endforeach; ?>
</tbody>

<!-- Nested Rows in Separate Tbody -->
<tbody class="nested-tbody">
    <?php foreach ($referrals as $referral): ?>
    <tr class="nested-table-row"
        id="details-<?= htmlspecialchars($referral['ta_id']) ?>"
        style="display: none;">
        <td colspan="4">
            <div class="nested-content"></div>
        </td>
    </tr>
    <?php endforeach; ?>
</tbody>