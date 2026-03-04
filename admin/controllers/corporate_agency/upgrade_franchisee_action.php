<?php
require "../../connect.php";

$id = $_POST['id'];
$id_str=substr($id,0,1);
if ($id_str == 'F') {
    $sql0 = "INSERT INTO sub_franchisee_upgrade (
                sub_franchisee_id,
                old_investment_amt,
                new_investment_amt,
                upgrade_amt,
                old_commission_per,
                new_commission_per,
                old_incentive_per,
                new_incentive_per,
                payment_mode,
                cheque_no,
                cheque_date,
                bank_name,
                transaction_no,
                payment_proof,
                note,
                upgrade_status
            ) VALUES (
                :sub_id,
                :old_amt,
                :new_amt,
                :upgrade_amt,
                :old_com,
                :new_com,
                :old_inc,
                :new_inc,
                :pay_mode,
                :cheque_no,
                :cheque_date,
                :bank_name,
                :txn_no,
                :pay_pf,
                :note,
                :status
            )";

            $stmt0 = $conn->prepare($sql0);

            $result = $stmt0->execute([
                ':sub_id'     => $_POST['id'],
                ':old_amt'    => $_POST['prev_amount'],
                ':new_amt'    => $_POST['new_amount'],
                ':upgrade_amt'=> $_POST['update_amount'],
                ':old_com'    => $_POST['prev_commission'] ?? 0,
                ':new_com'    => $_POST['commission'],
                ':old_inc'    => $_POST['prev_incentive'] ?? 0,
                ':new_inc'    => $_POST['incentive'],
                ':pay_mode'   => $_POST['payment_mode'],
                ':cheque_no'  => $_POST['cheque_no'] ?? 'NA',
                ':cheque_date'=> $_POST['cheque_date'] ?? 'NA',
                ':bank_name'  => $_POST['bank_name'] ?? 'NA',
                ':txn_no'     => $_POST['transaction_no'] ?? 'NA',
                ':pay_pf'     => $_POST['payment_proof'] ?? 'NA',
                ':note'       => $_POST['note'],
                ':status'     => 0   // 0 = Pending / Not applicable
            ]);
            
            if($result){

                $sql = "UPDATE sub_franchisee 
                        SET upgrade_status=:upgrade_status
                        WHERE sub_franchisee_id=:id";
                
                $stmt = $conn->prepare($sql);
                $result1 = $stmt->execute([
                    ':upgrade_status' => 1,
                    ':id' => $id
                ]);
                echo $result1 ? 1 : 0;
            }
}else if ($id_str == 'I') {
    $sql0 = "INSERT INTO institution_upgrade (
                institution_id,
                old_investment_amt,
                new_investment_amt,
                upgrade_amt,
                old_commission_per,
                new_commission_per,
                old_incentive_per,
                new_incentive_per,
                payment_mode,
                cheque_no,
                cheque_date,
                bank_name,
                transaction_no,
                payment_proof,
                note,
                upgrade_status
            ) VALUES (
                :sub_id,
                :old_amt,
                :new_amt,
                :upgrade_amt,
                :old_com,
                :new_com,
                :old_inc,
                :new_inc,
                :pay_mode,
                :cheque_no,
                :cheque_date,
                :bank_name,
                :txn_no,
                :pay_pf,
                :note,
                :status
            )";

            $stmt0 = $conn->prepare($sql0);

            $result = $stmt0->execute([
                ':sub_id'     => $_POST['id'],
                ':old_amt'    => $_POST['prev_amount'],
                ':new_amt'    => $_POST['new_amount'],
                ':upgrade_amt'=> $_POST['update_amount'],
                ':old_com'    => $_POST['prev_commission'] ?? 0,
                ':new_com'    => $_POST['commission'],
                ':old_inc'    => $_POST['prev_incentive'] ?? 0,
                ':new_inc'    => $_POST['incentive'],
                ':pay_mode'   => $_POST['payment_mode'],
                ':cheque_no'  => $_POST['cheque_no'] ?? 'NA',
                ':cheque_date'=> $_POST['cheque_date'] ?? 'NA',
                ':bank_name'  => $_POST['bank_name'] ?? 'NA',
                ':txn_no'     => $_POST['transaction_no'] ?? 'NA',
                ':pay_pf'     => $_POST['payment_proof'] ?? 'NA',
                ':note'       => $_POST['note'],
                ':status'     => 0   // 0 = Pending / Not applicable
            ]);
            
            if($result){

                $sql = "UPDATE institution 
                        SET upgrade_status=:upgrade_status
                        WHERE institution_id=:id";
                
                $stmt = $conn->prepare($sql);
                $result1 = $stmt->execute([
                    ':upgrade_status' => 1,
                    ':id' => $id
                ]);
                echo $result1 ? 1 : 0;
            }
}else{
    echo 'Invalid ID';
}


?>