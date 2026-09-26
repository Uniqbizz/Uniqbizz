<?php
// Need to add payout calculation and payout message for BM, MF and SF
// currently added only for ETE 
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
if ($id_str == 'I') {
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

            $sql1 = "SELECT reference_no, registrant, name FROM institution WHERE institution_id = :id";
            $stmt1 = $conn->prepare($sql1);

            $stmt1->execute([
                ':id' => $id
            ]);

            $result1 = $stmt1->fetch(PDO::FETCH_ASSOC);

            $f_name  = $result1['name'] ?? 'Not Applicable'; // Institution Name 

            ///////// ETE Information ////////
            $referenceNoETE = $result1['reference_no'] ?? 'Not Applicable'; // ETE Ref ID
            $registrantETE  = $result1['registrant'] ?? 'Not Applicable';  // ETE Ref Name
            $ref_strETE = substr($referenceNoETE,0,2); // ETE Ref ID 1st 2 letters "ET"
            $mf_sf_commis = $new_amount * 0.05; // Commission calculate for ETE 

            ///////// CTE Information ///////
            $sql2 = "SELECT reference_no, registrant, firstname, lastname FROM executive_techno_enterprise WHERE executive_techno_enterprise_id = :id";
            $stmt2 = $conn->prepare($sql2);
            $stmt2->execute([
                ':id' => $referenceNoETE
            ]);
            $result2 = $stmt2->fetch(PDO::FETCH_ASSOC);
            
            $referenceNoCTE = $result2['reference_no'] ?? 'Not Applicable'; // CTE Ref ID
            $registrantCTE  = $result2['registrant'] ?? 'Not Applicable';  // CTE Ref Name

            $ref_strCTE = substr($referenceNoCTE,0,2); // CTE Ref ID 1st 2 letters "CT"
            $emp_commis = $new_amount * 0.025; // Commission calculate for CTE

            $message_emp = $ref_strCTE.' - '.$registrantCTE.'(ID:'.$referenceNoCTE.') earned Rs '.$emp_commis.'/- on Institution upgrade With Reference of executive Techno Enterprise ' .$registrantETE . ' (ID:'.$referenceNoETE.'). Institution Name - '.$f_name.' (ID:'.$id.'). Institution Upgrade Amount: Rs '.$new_amount ; // CTE message
            $message_mf = $ref_strETE.' - '.$registrantETE.'(ID:'.$referenceNoETE.') earned Rs '.$mf_sf_commis.'/- on Institution upgrade.Institution Name - '.$f_name.' (ID:'.$id.'). Institution Upgrade Amount: Rs '.$new_amount ; //ETE message
            $message_f = 'Institution Name - '.$f_name.' (ID:'.$id.'). Institution Upgraded Amount: Rs '.$new_amount ; // Institution Message

            $sql = "INSERT INTO institution_payout (employees,message_emp,commission_emp,bm_mf_sf, message_bm_mf_sf, commission_bm_mf_sf, institution, 
                    message_institution, institution_amt_paid) 
                    VALUES (:employees,:message_emp,:commission_emp,:bm_mf_sf, :message_bm_mf_sf, :commission_bm_mf_sf, :institution,:message_institution, :institution_amt_paid) ";
            
            $stmt = $conn->prepare($sql);
            $result = $stmt->execute([
                ':employees' => $referenceNoCTE,
                ':message_emp'=> $message_emp, 
                ':commission_emp' => $emp_commis,
                ':bm_mf_sf' => $referenceNoETE, 
                ':message_bm_mf_sf' => $message_mf, 
                ':commission_bm_mf_sf' => $mf_sf_commis, 
                ':institution' => $id, 
                ':message_institution' => $message_f, 
                ':institution_amt_paid' => $new_amount
            ]);
            if ($result) {
                $message=$message2=$id.' Upgaded investment amount';
                $sql4 = "INSERT INTO logs (user_id,title,message,message2,from_whom,reference_no, operation) 
                            VALUES (:user_id,:title ,:message, :message2, :from_whom, :reference_no, :operation)";
                $stmt4 = $conn->prepare($sql4);

                $result3 = $stmt4->execute(array(
                    ':user_id' => $id,
                    ':title' => 'Franchisee Upgraded',
                    ':message' => $message,
                    ':message2' => $message2,
                    ':from_whom' => '1',
                    ':reference_no' => $referenceNoETE,
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