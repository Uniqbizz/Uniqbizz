<?php
    $sql100= "SELECT amount,reference_no FROM sub_franchisee WHERE sub_franchisee_id='".$userId."' and status=1";
    $stmt100 = $conn->prepare($sql100);
    $stmt100->execute();
    $stmt100->setFetchMode(PDO::FETCH_ASSOC);
    if ($stmt100->rowCount() > 0) {
        foreach (($stmt100->fetchAll()) as $key => $row) {
            $initial_inv = $row['amount'];
            $reference_no = $row['reference_no'];
        }
    }
    $sql101= "SELECT old_investment_amt,new_investment_amt,upgrade_amt as upgrade_amt  FROM sub_franchisee_upgrade
                        WHERE sub_franchisee_id='".$userId."' and upgrade_status=1
                        ORDER BY upgrade_approval_date DESC limit 1";
    $stmt101 = $conn->prepare($sql101);
    // print_r($stmt101);
    $stmt101->execute();
    $stmt101->setFetchMode(PDO::FETCH_ASSOC);
    if ($stmt101->rowCount() > 0) {
        foreach (($stmt101->fetchAll()) as $key => $row) {
            $tamount = $row['upgrade_amt'];
        }
    }else{
        $tamount = $initial_inv;
    }
?>