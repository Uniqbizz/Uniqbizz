<?php

// current full date
$today = date('Y-m-d');

// current year
$date = date('Y');

// Calculate 20 years before the current date
$ageLimit = date("Y-m-d", strtotime("-20 years"));

// request values (safe)
$row_id = $_REQUEST['id'] ?? '';
$id = $_REQUEST['sub_f_id'] ?? '';

// default values
$subId = '';
$frname = '';
$amount = '';
$prev_comm = '';
$prev_ins = '';
$prev_upgrade = '';

$new_amount = '';
$total_amount = '';
$commision = '';
$incentive = '';
$payment_mode = '';
$cheque_no = '';
$cheque_date = '';
$bank_name = '';
$transaction_no = '';
$payment_proof = '';
$note = '';
$rejection_reason = '';
$upgrade_status_val = '';


/* ----------------------------------------------------------
   Get Franchisee Details
---------------------------------------------------------- */

$sql1 = "SELECT sub_franchisee_id,
                CONCAT(firstname,' ',lastname) AS fname,
                amount,
                current_commission_per,
                current_incentive_per,
                upgrade_status
        FROM sub_franchisee
        WHERE sub_franchisee_id = :id";

$stmt = $conn->prepare($sql1);
$stmt->execute([':id' => $id]);

$franchisee = $stmt->fetch(PDO::FETCH_ASSOC);

if ($franchisee) {

    $subId = $franchisee['sub_franchisee_id'];
    $frname = $franchisee['fname'];
    $amount = $franchisee['amount'];
    $prev_comm = $franchisee['current_commission_per'];
    $prev_ins = $franchisee['current_incentive_per'];
    $prev_upgrade = $franchisee['upgrade_status'];

    /* ----------------------------------------------------------
       Check Upgrade Status
    ---------------------------------------------------------- */

    if ($prev_upgrade == 2) {

        // count upgrade entries
        $sql2_1 = "SELECT COUNT(id) AS id_count
                   FROM sub_franchisee_upgrade
                   WHERE sub_franchisee_id = :id
                   AND upgrade_status = 1";

        $stmt2_1 = $conn->prepare($sql2_1);
        $stmt2_1->execute([':id' => $id]);

        $result = $stmt2_1->fetch(PDO::FETCH_ASSOC);
        $idCount = isset($result['id_count']) ? (int)$result['id_count'] : 0;

        /* ---------- if first upgrade ---------- */

        if ($idCount === 1) {

            $amount = $franchisee['amount'];

        }

        /* ---------- if multiple upgrades ---------- */

        elseif ($idCount > 1) {

            $sql2_2 = "SELECT *
                       FROM sub_franchisee_upgrade
                       WHERE sub_franchisee_id = :id
                       AND id < :row_id
                       ORDER BY id DESC
                       LIMIT 1";

            $stmt2_2 = $conn->prepare($sql2_2);

            $stmt2_2->execute([
                ':id' => $id,
                ':row_id' => $row_id
            ]);

            $franchisee_upgrade_prev = $stmt2_2->fetch(PDO::FETCH_ASSOC);

            if ($franchisee_upgrade_prev) {
                $amount = $franchisee_upgrade_prev['upgrade_amt'];
            }
        }

        /* ----------------------------------------------------------
           Get Current Upgrade Entry
        ---------------------------------------------------------- */

        $sql2 = "SELECT *
                 FROM sub_franchisee_upgrade
                 WHERE sub_franchisee_id = :id
                 AND id = :row_id";

        $stmt2 = $conn->prepare($sql2);

        $stmt2->execute([
            ':id' => $id,
            ':row_id' => $row_id
        ]);

        $franchisee_upgrade = $stmt2->fetch(PDO::FETCH_ASSOC);

        if ($franchisee_upgrade) {

            $new_amount = $franchisee_upgrade['new_investment_amt'];
            $total_amount = $franchisee_upgrade['upgrade_amt'];
            $commision = $franchisee_upgrade['new_commission_per'];
            $incentive = $franchisee_upgrade['new_incentive_per'];
            $payment_mode = $franchisee_upgrade['payment_mode'];
            $cheque_no = $franchisee_upgrade['cheque_no'];
            $cheque_date = $franchisee_upgrade['cheque_date'];
            $bank_name = $franchisee_upgrade['bank_name'];
            $transaction_no = $franchisee_upgrade['transaction_no'];
            $payment_proof = $franchisee_upgrade['payment_proof'];
            $note = $franchisee_upgrade['note'];
            $rejection_reason = $franchisee_upgrade['rejection_reason'];
            $upgrade_status_val = $franchisee_upgrade['upgrade_status'];

        }

    }

}
?>