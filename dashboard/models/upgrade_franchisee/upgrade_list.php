<?php

    $sqlUnion = "SELECT id,new_investment_amt,upgrade_amt,upgrade_request_date,
                        upgrade_approval_date,new_commission_per,new_incentive_per,
                        payment_mode,rejection_reason,note,upgrade_status
                FROM sub_franchisee_upgrade
                WHERE sub_franchisee_id='".$userId."'
                ORDER BY upgrade_request_date ASC";

    $stmtUnion = $conn->prepare($sqlUnion);
    $stmtUnion->execute();
    $stmtUnion->setFetchMode(PDO::FETCH_ASSOC);

    if ($stmtUnion->rowCount() > 0) {

        foreach ($stmtUnion->fetchAll() as $row) {

            $udate = !empty($row['upgrade_request_date']) 
                ? date("d-m-Y", strtotime($row['upgrade_request_date'])) : '-';

            $adate = !empty($row['upgrade_approval_date']) 
                ? date("d-m-Y", strtotime($row['upgrade_approval_date'])) : '-';

            $amount = number_format($row['new_investment_amt']);
            $comm = $row['new_commission_per'];
            $inc = $row['new_incentive_per'];
            $pay_mode = ucfirst($row['payment_mode']);
            $note = $row['note'] ?? '-';
            $row_id = $row['id'];
            $rejection_reason = trim($row['rejection_reason'] ?? '');
            $status = $row['upgrade_status'];

            if ($rejection_reason === '') {
                $rejection_reason = '-';
            }

            echo "<tr>

                <td>$udate</td>

                <td><strong class='text-dark'>₹ $amount</strong></td>

                <td><span class='text-primary fw-semibold'>$comm%</span></td>

                <td><span class='text-success fw-semibold'>$inc%</span></td>

                <td>$pay_mode</td>

                <td>$note</td>

                <td>$adate</td>

                <td>$rejection_reason</td>

                <td>";

                if ($status == 0) {
                    echo "<span class='badge badge-soft-info'>Requested</span>";
                } elseif ($status == 1) {
                    echo "<span class='badge badge-soft-success'>Approved</span>";
                } elseif ($status == 2) {
                    echo "<span class='badge badge-soft-danger'>Rejected</span>";
                }

            echo "</td>

                <td class='text-center'>
                    <div class='dropdown'>
                        <a href='#' class='dropdown-toggle card-drop'
                        data-bs-toggle='dropdown'>
                        <i class='mdi mdi-dots-horizontal font-size-18'></i>
                        </a>
                        <ul class='dropdown-menu'>
                            <li>
                                <a href='#'
                                onclick='upgradeHistoryPage(\"$row_id\",\"$userId\")'
                                class='dropdown-item'>
                                <i class='mdi mdi-eye text-info me-1'></i>
                                View Details
                                </a>
                            </li>
                        </ul>
                    </div>
                </td>

            </tr>";
        }

    } else {
        echo "<tr>
                <td colspan='10' class='text-center text-muted py-4'>
                    No upgrade history found.
                </td>
            </tr>";
    }

?>