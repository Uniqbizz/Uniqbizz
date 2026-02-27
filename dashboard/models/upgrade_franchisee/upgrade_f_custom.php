<?php
    //current full date
    $today = date('Y-m-d');

    //current year
    $date = date('Y'); 

    // Calculate 20 years before the current date
    $dateTwentyYearsAgo = strtotime("-20 years");

    // Format the result as a human-readable date
    $ageLimit = date("Y-m-d", $dateTwentyYearsAgo);  // Outputs the date 20 years before today
    $row_id=$_REQUEST['id'];
    $id=$_REQUEST['sub_f_id'];
    $subId='';
    $frname='';
    $amount='';
    $sql1 = "SELECT sub_franchisee_id, CONCAT(firstname,' ',lastname) AS fname,amount,current_commission_per,current_incentive_per,upgrade_status 
         FROM sub_franchisee 
         WHERE sub_franchisee_id = :id";

    $stmt = $conn->prepare($sql1);

    $stmt->bindParam(':id', $id, PDO::PARAM_STR);  // $id must have the value before execute

    $stmt->execute();

    $franchisee = $stmt->fetch(PDO::FETCH_ASSOC);

    // get fname and sub_franchisee_id
    if ($franchisee) {
        $subId = $franchisee['sub_franchisee_id'];
        $frname = $franchisee['fname'];
        $amount = $franchisee['amount'];
        $prev_comm = $franchisee['current_commission_per'];
        $prev_ins = $franchisee['current_incentive_per'];
        $prev_upgrade=$franchisee['upgrade_status'];
        if($prev_upgrade == 2){
            // check how many entries are there
            $sql2_1 = "
                SELECT COUNT(id) AS id_count
                FROM sub_franchisee_upgrade
                WHERE sub_franchisee_id = :id 
                AND upgrade_status = 1
            ";

            $stmt2_1 = $conn->prepare($sql2_1);
            $stmt2_1->bindValue(':id', (string)$id, PDO::PARAM_STR);
            $stmt2_1->execute();

            $result = $stmt2_1->fetch(PDO::FETCH_ASSOC);
            $idCount = (int) ($result['id_count'] ?? 0);

            // if id_count is 1
            if ($idCount === 1) {
                $amount = $franchisee['amount'];
            }
            // if id_count is more than 1
            elseif ($idCount > 1) {
                // multiple upgrade entries
                $sql2_2 = "SELECT * 
                FROM sub_franchisee_upgrade 
                WHERE sub_franchisee_id = :id AND id < :row_id 
                ORDER BY id DESC LIMIT 1";

                $stmt2_2 = $conn->prepare($sql2_2);

                $stmt2_2->bindParam(':id', $id, PDO::PARAM_STR);  // $id must have the value before execute
                $stmt2_2->bindParam(':row_id', $row_id, PDO::PARAM_STR);  // $id must have the value before execute

                $stmt2_2->execute();
                $franchisee_upgrade_prev = $stmt2_2->fetch(PDO::FETCH_ASSOC);
                $amount = $franchisee_upgrade_prev['upgrade_amt'];
            }
            // if id_count is 0 (optional but good to handle)
            // else {
            //     // no upgrade entries
            // }

            $sql2 = "SELECT * 
                FROM sub_franchisee_upgrade 
                WHERE sub_franchisee_id = :id and id= :row_id";

            $stmt = $conn->prepare($sql2);

            $stmt->bindParam(':id', $id, PDO::PARAM_STR);  // $id must have the value before execute
            $stmt->bindParam(':row_id', $row_id, PDO::PARAM_STR);  // $id must have the value before execute

            $stmt->execute();

            $franchisee_upgrade = $stmt->fetch(PDO::FETCH_ASSOC);
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