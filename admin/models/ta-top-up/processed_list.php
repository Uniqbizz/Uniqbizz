<tbody>
    <?php
        require '../../connect.php';

        // Fetch all TAs with non-pending status
        $stmt = $conn->prepare("SELECT ta_id,SUM(top_up_amt) AS total_pending_amt FROM `ta_top_up_payment` WHERE status != 1 GROUP BY ta_id ORDER BY ta_id DESC");
        $stmt->execute();
        $referrals3 = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $stmt2 = $conn->prepare("SELECT DISTINCT  ta_id, ta_fname, ta_lname FROM `ta_top_up_payment` WHERE status != 1 ORDER BY ta_id DESC");
        $stmt2->execute();
        $referrals2 = $stmt2->fetchAll(PDO::FETCH_ASSOC);
        $j=0;
        // Create an associative array for fast lookup by ta_id
        $referrals2_lookup = [];
        foreach ($referrals2 as $row) {
            $referrals2_lookup[$row['ta_id']] = [
                'ta_fname' => $row['ta_fname'],
                'ta_lname' => $row['ta_lname']
            ];
        }

        // Now merge the data from $referrals and $referrals2 based on ta_id
        foreach ($referrals3 as &$referral) {
            $ta_id = $referral['ta_id'];

            // Check if ta_id exists in the $referrals2_lookup array
            if (isset($referrals2_lookup[$ta_id])) {
                $referral['ta_fname'] = $referrals2_lookup[$ta_id]['ta_fname'];
                $referral['ta_lname'] = $referrals2_lookup[$ta_id]['ta_lname'];
            }
        }
        $i=0;
        foreach ($referrals3 as $referral3): ?>
        <?php
            $ta_id = htmlspecialchars($referral3["ta_id"]);
            $ta_name = htmlspecialchars($referral3['ta_fname'] . ' ' . $referral3['ta_lname']);

            // Fetch approved and rejected amounts
            $stmt_status = $conn->prepare("
                SELECT status, SUM(top_up_amt) AS total_amt
                FROM ta_top_up_payment
                WHERE ta_id = ? AND status IN (2,3)
                GROUP BY status
            ");
            $stmt_status->execute([$ta_id]);
            $status_amounts = $stmt_status->fetchAll(PDO::FETCH_KEY_PAIR);

            $total_approved = $status_amounts[2] ?? 0;
            $total_rejected = $status_amounts[3] ?? 0;
            ?>

        <tr class="main-row" data-ta-id="<?= $ta_id ?>">
            <td class="details-control">+</td>
            <td><?= $ta_name ?></td>
            <td>Approved (<?= number_format($total_approved, 2) ?>) Rejected
                (<?= number_format($total_rejected, 2) ?>)</td>
            <td>
                <div class="dropdown">
                    <a class="" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="mdi mdi-dots-horizontal mdi-24px" style="color: grey;">
                        </i>
                    </a>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    <a class="dropdown-item exportCSV1" href="#" data-ta-id="<?= $ta_id ?>">
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
    <?php foreach ($referrals3 as $referral3): ?>
    <tr class="nested-table-row"
        id="secdetails-<?= htmlspecialchars($referral3["ta_id"]) ?>"
        style="display: none;">
        <td colspan="4">
            <div class="nested-content1"></div>
        </td>
    </tr>
    <?php endforeach; ?>
</tbody>