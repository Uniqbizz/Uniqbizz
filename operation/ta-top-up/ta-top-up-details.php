<?php
require '../connect.php';

if (isset($_POST['ta_id'])) {
    $ta_id = $_POST['ta_id'];

    $stmt = $conn->prepare("
        SELECT * FROM `ta_top_up_payment` 
        WHERE status = 1 AND ta_id = ? 
        ORDER BY ID DESC
    ");
    $stmt->execute([$ta_id]);
    $referrals = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (count($referrals) > 0) {
        echo "<div class='table-responsive'>
        <table class='table align-middle table-bordered w-100'>
        <thead class='table-light'>
            <tr>
                <th>Id</th>
                <th>Name of TA</th>
                <th>TopUp Amount</th>
                <th>Payment Method</th>
                <th>Created Date</th>
                <th>Updated Date</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>";

        $i = 0;
        foreach ($referrals as $referral) {
            echo '<tr>
                <td>' . ++$i . '</td>
                <td>' . htmlspecialchars($referral['ta_fname'] . ' ' . $referral['ta_lname']) . '</td>
                <td>' . number_format($referral['top_up_amt'], 2) . '</td>
                <td>' . htmlspecialchars($referral['pay_mode']) . '</td>
                <td>' . htmlspecialchars($referral['created_date']) . '</td>
                <td>' . htmlspecialchars($referral['updated_date']) . '</td>
                
                <td><span class="badge bg-warning">Pending</span></td>
                <td>
                    <div class="dropdown">
                        <a id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="mdi mdi-dots-horizontal mdi-24px" style="color: grey;"></i>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#viewpay"
                               onclick=\'showoverlay(
                                   "' . htmlspecialchars($referral['ta_id']) . '",
                                   "' . htmlspecialchars($referral['ta_fname']) . '",
                                   "' . htmlspecialchars($referral['ta_lname']) . '",
                                   "' . htmlspecialchars($referral['top_up_amt']) . '",
                                   "' . htmlspecialchars($referral['pay_mode']) . '",
                                   "' . htmlspecialchars($referral['cheque_no']) . '",
                                   "' . htmlspecialchars($referral['cheque_date']) . '",
                                   "' . htmlspecialchars($referral['bank_name']) . '",
                                   "' . htmlspecialchars($referral['transaction_id']) . '",
                                   "' . htmlspecialchars($referral['ref_img']) . '",
                                   "' . htmlspecialchars($referral['created_date']) . '",
                                   "1","'.$referral['id'] . '"
                               )\'>
                               <i class="mdi mdi-eye font-size-16 text-primary me-1"></i>View
                            </a>
                        </div>
                    </div>
                </td>
            </tr>';
        }

        echo "</tbody></table></div>";
    } else {
        echo "<p>No records found.</p>";
    }
}
