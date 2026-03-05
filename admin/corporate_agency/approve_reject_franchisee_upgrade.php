<?php
require "../connect.php";

$id = $_POST['id'];
$id_str=substr($id,0,1);
$action = $_POST['action'];
$reason = $_POST['reason'];
$upgrade_id = $_POST['rec_id'];
$current_date=date('Y-m-d');
$status=0;
if($action == 'approve'){
    $status=1;
}else if($action == 'reject'){
    $status=2;
}
if ($id_str == 'F') {
    $sql0 ="UPDATE sub_franchisee_upgrade SET
            upgrade_status = :status,
            approved_by = :approved_by,
            upgrade_approval_date = :upgrade_approval_date,
            rejection_reason = :rejection_reason
        WHERE id = :upgrade_id";

    $stmt0 = $conn->prepare($sql0);

    $result = $stmt0->execute([
        ':status' => $status,   // 0 = Pending, 1 = Approved, 2 = Rejected
        ':approved_by' => 1,
        ':upgrade_approval_date' => $current_date,
        ':rejection_reason' => $reason,
        ':upgrade_id' => $upgrade_id
    ]);


    if($result){
        if($status == 1){
                
            //on upgrade MF/SF payout
            //get the upgrade amount
            $sql0 ="SELECT new_investment_amt 
                    FROM sub_franchisee_upgrade 
                    WHERE sub_franchisee_id = :id AND id = :upgrade_id";
            $stmt0 = $conn->prepare($sql0);

            $stmt0->execute([
                ':id' => $id,
                ':upgrade_id' => $upgrade_id
            ]);

            $result0 = $stmt0->fetch(PDO::FETCH_ASSOC);

            $new_amount = $result0['new_investment_amt'] ?? 'Not Applicable';

            $sql1 = "SELECT reference_no, registrant, CONCAT(firstname,' ',lastname) AS name FROM sub_franchisee WHERE sub_franchisee_id = :id";
            $stmt1 = $conn->prepare($sql1);

            $stmt1->execute([
                ':id' => $id
            ]);

            $result1 = $stmt1->fetch(PDO::FETCH_ASSOC);

            $referenceNo = $result1['reference_no'] ?? 'Not Applicable';
            $registrant  = $result1['registrant'] ?? 'Not Applicable';
            $f_name  = $result1['name'] ?? 'Not Applicable';
            $ref_str=substr($referenceNo,0,2);
            $mf_sf_commis=$new_amount * 0.05;

            $message_mf = $ref_str.' - '.$registrant.'(ID:'.$referenceNo.') earned Rs '.$mf_sf_commis.'/- on Franchisee upgrade.Franchisee Name - '.$f_name.' (ID:'.$id.'). Franchisee Upgrade Amount: Rs '.$new_amount ;
            $message_f = 'Franchisee Name - '.$f_name.' (ID:'.$id.'). Franchisee Upgraded Amount: Rs '.$new_amount ;

            $sql = "INSERT INTO sub_franchisee_payout (zonal_manager,message_zm,commission_zm,master_franchisee, message_mf, commission_mf, sub_franchisee, 
                    message_sf, sf_amt_paid) 
                    VALUES (:zonal_manager,:message_zm,:commission_zm,:master_franchisee, :message_mf, :commission_mf, :sub_franchisee,:message_sf, :sf_amt_paid) ";
            
            $stmt = $conn->prepare($sql);
            $result = $stmt->execute([
                ':zonal_manager' => 'NA',
                ':message_zm'=>'Not Applicable',
                ':commission_zm' => 0,
                ':master_franchisee' => $referenceNo, 
                ':message_mf' => $message_mf, 
                ':commission_mf' => $mf_sf_commis, 
                ':sub_franchisee' => $id, 
                ':message_sf' => $message_f, 
                ':sf_amt_paid' => $new_amount
            ]);
            if ($result) {
                $message=$message2=$id.' Upgaded investment amount';
                $sql4 = "INSERT INTO logs (user_id,title,message,message2,reference_no, operation) 
                            VALUES (:user_id,:title ,:message, :message2, :reference_no, :operation)";
                $stmt4 = $conn->prepare($sql4);

                $result3 = $stmt4->execute(array(
                    ':user_id' => $id,
                    ':title' => 'Franchisee Upgraded',
                    ':message' => $message,
                    ':message2' => $message2,
                    ':reference_no' => $referenceNo,
                    ':operation' => 'Upgrade Franchisee'
                ));
                if($result3){
                    $sql = "UPDATE sub_franchisee 
                            SET upgrade_status=:upgrade_status
                            WHERE sub_franchisee_id=:id";
                    
                    $stmt = $conn->prepare($sql);
                    $result1 = $stmt->execute([
                        ':upgrade_status' => 2,
                        ':id' => $id
                    ]);
                    
                    echo $status ;
                }
            }
        }else{
            
            $sql = "UPDATE sub_franchisee 
                    SET upgrade_status=:upgrade_status
                    WHERE sub_franchisee_id=:id";
            
            $stmt = $conn->prepare($sql);
            $result1 = $stmt->execute([
                ':upgrade_status' => 2,
                ':id' => $id
            ]);
            
            echo $status ;
        }
        
    }
} else if ($id_str == 'I') {
    $sql0 ="UPDATE institution_upgrade SET
            upgrade_status = :status,
            approved_by = :approved_by,
            upgrade_approval_date = :upgrade_approval_date,
            rejection_reason = :rejection_reason
        WHERE id = :upgrade_id";

    $stmt0 = $conn->prepare($sql0);

    $result = $stmt0->execute([
        ':status' => $status,   // 0 = Pending, 1 = Approved, 2 = Rejected
        ':approved_by' => 1,
        ':upgrade_approval_date' => $current_date,
        ':rejection_reason' => $reason,
        ':upgrade_id' => $upgrade_id
    ]);


    if($result){
        if($status == 1){
                
            //on upgrade MF/SF payout
            //get the upgrade amount
            $sql0 ="SELECT new_investment_amt 
                    FROM institution_upgrade 
                    WHERE institution_id = :id AND id = :upgrade_id";
            $stmt0 = $conn->prepare($sql0);

            $stmt0->execute([
                ':id' => $id,
                ':upgrade_id' => $upgrade_id
            ]);

            $result0 = $stmt0->fetch(PDO::FETCH_ASSOC);

            $new_amount = $result0['new_investment_amt'] ?? 'Not Applicable';

            $sql1 = "SELECT reference_no, registrant, CONCAT(firstname,' ',lastname) AS name FROM institution WHERE institution_id = :id";
            $stmt1 = $conn->prepare($sql1);

            $stmt1->execute([
                ':id' => $id
            ]);

            $result1 = $stmt1->fetch(PDO::FETCH_ASSOC);

            $referenceNo = $result1['reference_no'] ?? 'Not Applicable';
            $registrant  = $result1['registrant'] ?? 'Not Applicable';
            $f_name  = $result1['name'] ?? 'Not Applicable';
            $ref_str=substr($referenceNo,0,2);
            $mf_sf_commis=$new_amount * 0.05;

            $message_mf = $ref_str.' - '.$registrant.'(ID:'.$referenceNo.') earned Rs '.$mf_sf_commis.'/- on Institution upgrade.Institution Name - '.$f_name.' (ID:'.$id.'). Institution Upgrade Amount: Rs '.$new_amount ;
            $message_f = 'Institution Name - '.$f_name.' (ID:'.$id.'). Institution Upgraded Amount: Rs '.$new_amount ;

            $sql = "INSERT INTO institution_payout (employees,message_emp,commission_emp,bm_mf_sf, message_bm_mf_sf, commission_bm_mf_sf, institution, 
                    message_institution, institution_amt_paid) 
                    VALUES (:employees,:message_emp,:commission_emp,:bm_mf_sf, :message_bm_mf_sf, :commission_bm_mf_sf, :institution,:message_institution, :institution_amt_paid) ";
            
            $stmt = $conn->prepare($sql);
            $result = $stmt->execute([
                ':employees' => 'NA',
                ':message_emp'=>'Not Applicable',
                ':commission_emp' => 0,
                ':bm_mf_sf' => $referenceNo, 
                ':message_bm_mf_sf' => $message_mf, 
                ':commission_bm_mf_sf' => $mf_sf_commis, 
                ':institution' => $id, 
                ':message_institution' => $message_f, 
                ':institution_amt_paid' => $new_amount
            ]);
            if ($result) {
                $message=$message2=$id.' Upgaded investment amount';
                $sql4 = "INSERT INTO logs (user_id,title,message,message2,reference_no, operation) 
                            VALUES (:user_id,:title ,:message, :message2, :reference_no, :operation)";
                $stmt4 = $conn->prepare($sql4);

                $result3 = $stmt4->execute(array(
                    ':user_id' => $id,
                    ':title' => 'Franchisee Upgraded',
                    ':message' => $message,
                    ':message2' => $message2,
                    ':reference_no' => $referenceNo,
                    ':operation' => 'Upgrade Franchisee'
                ));
                if($result3){
                    $sql = "UPDATE institution 
                            SET upgrade_status=:upgrade_status
                            WHERE institution_id=:id";
                    
                    $stmt = $conn->prepare($sql);
                    $result1 = $stmt->execute([
                        ':upgrade_status' => 2,
                        ':id' => $id
                    ]);
                    
                    echo $status ;
                }
            }
        }else{
            
            $sql = "UPDATE institution 
                    SET upgrade_status=:upgrade_status
                    WHERE institution_id=:id";
            
            $stmt = $conn->prepare($sql);
            $result1 = $stmt->execute([
                ':upgrade_status' => 2,
                ':id' => $id
            ]);
            
            echo $status ;
        }
        
    }
} else {
    # code...
}
?>