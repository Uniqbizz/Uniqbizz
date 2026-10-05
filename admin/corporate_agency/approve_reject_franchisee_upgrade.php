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

            $new_amount = (float)$result0['new_investment_amt'];

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
} else if ($id_str == 'T' || $id_str == 'C' ) {
    $sql0 ="UPDATE techno_enterprise_upgrade SET
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
                    FROM techno_enterprise_upgrade 
                    WHERE techno_enterprise_id = :id AND id = :upgrade_id";
            $stmt0 = $conn->prepare($sql0);

            $stmt0->execute([
                ':id' => $id,
                ':upgrade_id' => $upgrade_id
            ]);

            $result0 = $stmt0->fetch(PDO::FETCH_ASSOC);

            $new_amount = (float) $result0['new_investment_amt'];

            $sql1 = "SELECT reference_no, registrant, CONCAT(firstname,' ',lastname) AS name FROM corporate_agency WHERE corporate_agency_id = :id";
            $stmt1 = $conn->prepare($sql1);

            $stmt1->execute([
                ':id' => $id
            ]);
            //defaults
            $CTE_id = '';
            $CTE_name = "";
            $CTE_message = '';
            $CTECommiAmt = 0;
            $ETE_id = '';
            $ETE_name = "";
            $ETE_message = '';
            $ETECommiAmt = 0;
            $STE_id = '';
            $STE_name = "";
            $STE_message = '';
            $TE_message = '';
            $STECommiAmt = 0;
            $result1 = $stmt1->fetch(PDO::FETCH_ASSOC);

            $referenceNo = $result1['reference_no'] ?? 'Not Applicable';
            $registrant  = $result1['registrant'] ?? 'Not Applicable';
            $f_name  = $result1['name'] ?? 'Not Applicable';
            $ref_str=substr($referenceNo,0,2);
            $ref_str = ($ref_str == 'BM')
                        ? 'BM'
                        : (($ref_str == 'BH')
                            ? 'BDM'
                            : (($ref_str == 'ST')
                                ? 'STE'
                                : $ref_str
                            )
                        );
            
            //identify the TE Upper chain
            if ($ref_str == "BM") { 
                $STECommiAmt=$new_amount * 0.05;

                
                // Get BM ref
                $stmt = $conn->prepare("SELECT business_mentor_id,CONCAT(firstname, ' ', lastname) AS name,registrant,reference_no FROM business_mentor WHERE status = '1'");
                $stmt->execute();
                $bm_data = $stmt->fetch(PDO::FETCH_ASSOC);
                $ETECommiAmt=$new_amount * 0.025;
                $STE_id=$bm_data['business_mentor_id'];
                $STE_name=$bm_data['name'];
                $registrant=$bm_data['registrant'];
                $referenceNo=$bm_data['referenceNo'];
                $STE_message = $ref_str.' - '.$STE_name.'(ID:'.$STE_id.') earned Rs '.$STECommiAmt.'/- on Techno Enterprise upgrade.Techno Enterprise Name - '.$f_name.' (ID:'.$id.'). Techno Enterprise Upgrade Amount: Rs '.$new_amount ;
                $TE_message = 'Techno Enterprise Name - '.$f_name.' (ID:'.$id.'). Techno Enterprise Upgraded Amount: Rs '.$new_amount ;
                $ETE_message = 'BDM - '.$registrant.'(ID:'.$referenceNo.') earned Rs '.$ETECommiAmt.'/- on Techno Enterprise upgrade.Techno Enterprise Name - '.$f_name.' (ID:'.$id.'). Techno Enterprise Upgrade Amount: Rs '.$new_amount.". With Reference of Business Developement Manager ".$STE_name." ".$STE_id."." ;
                
            } else if($ref_str == "STE"){ //new TE payout table to handle for STE->ETE->CTE
                $STECommiAmt=$new_amount * 0.05;

                $STE_message = $ref_str.' - '.$registrant.'(ID:'.$referenceNo.') earned Rs '.$STECommiAmt.'/- on Techno Enterprise upgrade.Techno Enterprise Name - '.$f_name.' (ID:'.$id.'). Techno Enterprise Upgrade Amount: Rs '.$new_amount ;
                $TE_message = 'Techno Enterprise Name - '.$f_name.' (ID:'.$id.'). Techno Enterprise Upgraded Amount: Rs '.$new_amount ;

                $sql10 = $conn->prepare("SELECT * FROM super_techno_enterprise WHERE super_techno_enterprise_id = '" . $referenceNo . "'");
                $sql10->execute();
                $sql10->setFetchMode(PDO::FETCH_ASSOC);
                if ($sql10->rowCount() > 0) {
                    foreach (($sql10->fetchAll()) as $key10 => $row10) {
                        $STE_id = $row10['super_techno_enterprise_id'];
                        $STE_name = $row10['firstname'] . ' ' . $row10['lastname'];
                        $STE_ref = $row10['reference_no']??'';
                    }
                }
                if ($STE_ref) {
                    $sql11 = $conn->prepare("SELECT * FROM executive_techno_enterprise WHERE executive_techno_enterprise_id = '" . $STE_ref . "'");
                    $sql11->execute();
                    $sql11->setFetchMode(PDO::FETCH_ASSOC);
                    if ($sql11->rowCount() > 0) {
                        foreach (($sql11->fetchAll()) as $key11 => $row11) {
                            $ETE_id = $row11['executive_techno_enterprise_id'];
                            $ETE_name = $row11['firstname'] . ' ' . $row11['lastname'];
                            $ETE_ref = $row11['reference_no']??'';
                            // $ETE_user_type_id = $row11['user_type'];
                            // $ETE_ref = $row11['reporting_manager'];
                        }
                    }
                }
                if ($ETE_ref) {
                    $sql12 = $conn->prepare("SELECT * FROM chief_techno_enterprise WHERE chief_techno_enterprise_id = '" . $ETE_ref . "'");
                    $sql12->execute();
                    $sql12->setFetchMode(PDO::FETCH_ASSOC);
                    if ($sql12->rowCount() > 0) {
                        foreach (($sql12->fetchAll()) as $key12 => $row12) {
                            $CTE_id = $row12['chief_techno_enterprise_id'];
                            $CTE_name = $row12['firstname'] . ' ' . $row12['lastname'];
                            // $bdm_user_type_id = $row11['user_type'];
                            // $bdm_ref = $row11['reporting_manager'];
                        }
                    }
                }

                $CTECommiAmt = $new_amount * 0.0125; // 1.25%

                $ETECommiAmt = $new_amount * 0.025; // 2.5%

                $STECommiAmt = $new_amount * 0.05; // 5%

                // $STE_message = 
                //     "STE - " . $STE_name .
                //     " (ID: " . $STE_id . ") earned Rs " . $STECommiAmt .
                //     "/- on Techno Enterprise upgrade. " .
                //     "Techno Enterprise Name - " . $f_name .
                //     " (ID: " . $id . "). " .
                //     "Techno Enterprise Upgrade Amount: Rs " . $new_amount . ".";


                $ETE_message = 
                    "ETE - " . $ETE_name .
                    " (ID: " . $ETE_id . ") earned Rs " . $ETECommiAmt .
                    "/- on Techno Enterprise upgrade. " .
                    "Techno Enterprise Name - " . $f_name .
                    " (ID: " . $id . "). " .
                    "Techno Enterprise Upgrade Amount: Rs " . $new_amount .
                    ". With Reference of Super Techno Enterprise " .
                    $STE_name . " (" . $STE_id . ").";


                $CTE_message = 
                    "CTE - " . $CTE_name .
                    " (ID: " . $CTE_id . ") earned Rs " . $CTECommiAmt .
                    "/- on Techno Enterprise upgrade. " .
                    "Techno Enterprise Name - " . $f_name .
                    " (ID: " . $id . "). " .
                    "Techno Enterprise Upgrade Amount: Rs " . $new_amount .
                    ". With Reference of Executive Techno Enterprise " .
                    $ETE_name . " (" . $ETE_id . ").";

            }else if ($ref_str == "BDM") { 
                $STE_id = '';
                $STE_message = '';
                $STECommiAmt = 0;
                $ETECommiAmt=$new_amount * 0.05;
                $ETE_id = $referenceNo;

                $ETE_message = $ref_str.' - '.$registrant.'(ID:'.$referenceNo.') earned Rs '.$ETECommiAmt.'/- on Techno Enterprise upgrade.Techno Enterprise Name - '.$f_name.' (ID:'.$id.'). Techno Enterprise Upgrade Amount: Rs '.$new_amount ;
                $TE_message = 'Techno Enterprise Name - '.$f_name.' (ID:'.$id.'). Techno Enterprise Upgraded Amount: Rs '.$new_amount ;
  
            }
            $sqlTEPayout=$conn->prepare("
                                INSERT INTO techno_enterprise_payout (cte_id, cte_message, cte_amount, cte_status, ete_id, 
                                            ete_message, ete_amount, ete_status, ste_id, ste_message, ste_amount, ste_status, 
                                            te_id, te_message, te_amount) 
                                VALUES (:cte_id, :cte_message, :cte_amount, :cte_status, :ete_id, 
                                            :ete_message, :ete_amount, :ete_status, :ste_id, :ste_message, :ste_amount, :ste_status, 
                                            :te_id, :te_message, :te_amount)
                                ");
            $result = $sqlTEPayout->execute([
                ":cte_id"			=>	$CTE_id ?? '',
                ":cte_message"		=>	$CTE_message ?? '',
                ":cte_amount" 		=>	$CTECommiAmt ,
                ":cte_status" 		=>	2,
                ":ete_id" 			=>	$ETE_id,
                ":ete_message" 		=>	$ETE_message,
                ":ete_amount" 		=>	$ETECommiAmt,
                ":ete_status" 		=>	2,
                ":ste_id" 			=>	$STE_id,
                ":ste_message" 		=>	$STE_message,
                ":ste_amount" 		=>	$STECommiAmt,
                ":ste_status" 		=>	2,
                ":te_id" 			=>	$id,
                ":te_message" 		=>	$TE_message,
                ":te_amount"		=>	$new_amount
            ]);
            if ($result) {
                $message=$message2=$id.' Upgaded investment amount';
                $sql4 = "INSERT INTO logs (user_id,title,message,message2,reference_no, operation,from_whom) 
                            VALUES (:user_id,:title ,:message, :message2, :reference_no, :operation,:from_whom)";
                $stmt4 = $conn->prepare($sql4);

                $result3 = $stmt4->execute(array(
                    ':user_id' => $id,
                    ':title' => 'Techno Enterprise Upgraded',
                    ':message' => $message,
                    ':message2' => $message2,
                    ':reference_no' => $referenceNo,
                    ':operation' => 'Upgrade Techno Enterprise',
                    ':from_whom' => 1
                ));
                if($result3){
                    $sql = "UPDATE corporate_agency 
                            SET upgrade_status=:upgrade_status
                            WHERE corporate_agency_id=:id";
                    
                    $stmt = $conn->prepare($sql);
                    $result1 = $stmt->execute([
                        ':upgrade_status' => 2,
                        ':id' => $id
                    ]);
                    
                    echo $status ;
                }
            }
        }else{
            
            $sql = "UPDATE corporate_agency 
                    SET upgrade_status=:upgrade_status
                    WHERE corporate_agency_id=:id";
            
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