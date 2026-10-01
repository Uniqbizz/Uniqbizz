<?php

    require '../../../connect.php';
    $payoutYear = $_GET['payoutYear'] ?? '';
    $payoutMonth = $_GET['payoutMonth'] ?? '';
    $payoutmessage = $_GET['payoutmessage'] ?? '';
    $designation = $_GET['designation'] ?? '';
    $user_id = $_GET['user_id'] ?? '';
    
    $monthNumber = filter_var(
        $payoutMonth,
        FILTER_VALIDATE_INT
    );
    
    if ($monthNumber !== false && $monthNumber >= 1 && $monthNumber <= 12) {
    
        $dateObj = DateTime::createFromFormat(
            '!m',
            (string)$monthNumber
        );
    
        $monthName = $dateObj->format('F');
    
    } else {
        $monthName = '';
    }
    
    if($payoutmessage == 'PreviousPayout'){
        $output="";
        // $stmt2 = "SELECT * FROM ca_payout WHERE YEAR(created_date) = '".$payoutYear."' AND MONTH(created_date) = '".$payoutMonth."' ";
    
        $stmt2 = "SELECT id, bdm_id as bmId, message, message_details, comm_amt, techno_enterprise, created_date, status, 'goaBdm' as identity FROM `goa_bdm_payout` WHERE YEAR(created_date) = '".$payoutYear."' AND MONTH(created_date) = '".$payoutMonth."'  UNION ALL
                SELECT id, bm_id as bmId, message, message_details, comm_amt, techno_enterprise, created_date, status, 'goaBm' as identity FROM `goa_bm_payout` WHERE YEAR(created_date) = '".$payoutYear."' AND MONTH(created_date) = '".$payoutMonth."'  UNION ALL
                SELECT id, business_mentor as bmId, message, message_details, comm_amt, techno_enterprise, created_date, status, 'caPayout' as identity FROM `ca_payout` WHERE YEAR(created_date) = '".$payoutYear."' AND MONTH(created_date) = '".$payoutMonth."'  UNION ALL
                SELECT id, bm_user_id as bmId, message_bm as message, payment_message as message_details, payout_amount as comm_amt, ca_user_id as techno_enterprise, payout_date as created_date, payout_status as status, 'bmPayoutHistory' as identity FROM `bm_payout_history` WHERE YEAR(payout_date) = '".$payoutYear."' AND MONTH(payout_date) = '".$payoutMonth."' UNION ALL
                SELECT id, cte_id as bmId, cte_message as message, '' as message_details, cte_amount as comm_amt, te_id as techno_enterprise, created_date, cte_status as status, 'CTE' as identity FROM `techno_enterprise_payout` WHERE YEAR(created_date) = '".$payoutYear."' AND MONTH(created_date) = '".$payoutMonth."' UNION ALL
                SELECT id, ete_id as bmId, ete_message as message, '' as message_details, ete_amount as comm_amt, te_id as techno_enterprise, created_date, ete_status as status, 'ETE' as identity FROM `techno_enterprise_payout` WHERE YEAR(created_date) = '".$payoutYear."' AND MONTH(created_date) = '".$payoutMonth."' UNION ALL
                SELECT id, ste_id as bmId, ste_message as message, '' as message_details, ste_amount as comm_amt, te_id as techno_enterprise, created_date, ste_status as status, 'STE' as identity FROM `techno_enterprise_payout` WHERE YEAR(created_date) = '".$payoutYear."' AND MONTH(created_date) = '".$payoutMonth."' ";
    
        $stmt2 = $conn -> prepare($stmt2);
        $stmt2 -> execute();
        $stmt2 ->setFetchMode(PDO::FETCH_ASSOC);
        if($stmt2 -> rowCount()>0){
        	$output .= '<h2 style="text-align:center">Previous Payout List as of '.$monthName.','.$payoutYear.'</h2>
            <table border="1" style="text-align:center">
                <tr>
                    <th >Date</th>
                    <th class="mobile_view">BDM/BM/CTE/ETE/STE</th>
                    <th class="mobile_view">BDM/BM/CTE/ETE/STE Name</th>
                    <th class="mobile_view">Techno Enterprise</th>
                    <th class="mobile_view">Techno Enterprise Name</th>
                    <th ><span class="long-name">Payout Message</th>
                    <th ><span class="long-name">Payout Details</th>
                    <th class="mobile_view tab_view">Amount</th>
                    <th class="mobile_view" >TDS</th>
                    <th style="text-align:center;">Total Payable</th>
                    <th style="text-align:center;">Status</th>
                </tr>';
                foreach($stmt2->fetchAll() as $key => $row2){
                    $rd= new DateTime($row2['created_date']);
                    $newDate= $rd->format('d-m-Y');
                    $id = $row2['id'];
    
                    // get the commission amount of BA's
                    $Commi = $row2['comm_amt'];
                    
                    (int)$Commi_TDS = (int)$Commi*2/100;
                    (int)$Commi_Total = (int)$Commi-(int)$Commi_TDS; 
    
    
                    // date in proper formate
                    $dt = new DateTime($row2['created_date']);
                    $dt = $dt->format('Y-m-d');
    
                    // replace dot at end of the line with break statement
                    $message1 = $row2['message'];
                    $message1 =  str_replace('.','<br>',$message1); 
                    $message2 = $row2['message_details'];
                    $message2 =  str_replace('.','<br>',$message2); 
    
                    $userId = $row2['bmId'];
                    $userIdty = substr($userId,0,2);
                    
                    if($userIdty == "BM"){
                        $bcNames = $conn -> prepare("SELECT firstname,lastname FROM business_mentor WHERE business_mentor_id = '".$userId."' AND status = 1");
                        $bcNames -> execute();
                        $bcNames -> setFetchMode(PDO::FETCH_ASSOC);
                        if($bcNames -> rowCount()>0){
                            foreach(($bcNames -> fetchAll()) as $key => $row1){
                                $bm_name = $row1['firstname']. ' ' .$row1['lastname'];
                            }
                        }  
                    }else if($userIdty == "BH"){
                        $bcNames = $conn -> prepare("SELECT * FROM employees WHERE employee_id = '".$userId."' AND user_type = '25' AND status = 1");
                        $bcNames -> execute();
                        $bcNames -> setFetchMode(PDO::FETCH_ASSOC);
                        if($bcNames -> rowCount()>0){
                            foreach(($bcNames -> fetchAll()) as $key => $row1){
                               $bm_name = $row1['name'];
                            }
                        }  
                    }
                    // else if($userIdty == "TE" || $userIdty == "CA"){
                    //     $bcNames = $conn -> prepare("SELECT * FROM corporate_agency WHERE corporate_agency_id = '".$userId."' AND status = 1");
                    //     $bcNames -> execute();
                    //     $bcNames -> setFetchMode(PDO::FETCH_ASSOC);
                    //     if($bcNames -> rowCount()>0){
                    //         foreach(($bcNames -> fetchAll()) as $key => $row){
                    //             $bcfirstname = $row['firstname'];
                    //             $bclastname = $row['lastname'];
                    //             $designation = "Techno Enterprise";
                    //         }
                    //     }  
                    // }
                    else if($userIdty == "CT"){
                        $bcNames = $conn -> prepare("SELECT * FROM chief_techno_enterprise WHERE chief_techno_enterprise_id = '".$userId."' AND status = 1");
                        $bcNames -> execute();
                        $bcNames -> setFetchMode(PDO::FETCH_ASSOC);
                        if($bcNames -> rowCount()>0){
                            foreach(($bcNames -> fetchAll()) as $key => $row1){
                                $bm_name = $row1['firstname']. ' ' .$row1['lastname'];
                            }
                        }  
                    }else if($userIdty == "ET"){
                        $bcNames = $conn -> prepare("SELECT * FROM executive_techno_enterprise WHERE executive_techno_enterprise_id = '".$userId."' AND status = 1");
                        $bcNames -> execute();
                        $bcNames -> setFetchMode(PDO::FETCH_ASSOC);
                        if($bcNames -> rowCount()>0){
                            foreach(($bcNames -> fetchAll()) as $key => $row1){
                                $bm_name = $row1['firstname']. ' ' .$row1['lastname'];
                            }
                        }  
                    }else if($userIdty == "ST"){
                        $bcNames = $conn -> prepare("SELECT * FROM super_techno_enterprise WHERE super_techno_enterprise_id = '".$userId."' AND status = 1");
                        $bcNames -> execute();
                        $bcNames -> setFetchMode(PDO::FETCH_ASSOC);
                        if($bcNames -> rowCount()>0){
                            foreach(($bcNames -> fetchAll()) as $key => $row1){
                                $bm_name = $row1['firstname']. ' ' .$row1['lastname'];
                            }
                        }  
                    }
    
                    $sql2= $conn->prepare("SELECT firstname,lastname FROM `corporate_agency` where corporate_agency_id='".$row2['techno_enterprise']."'");
                    $sql2->execute();
                    $sql2->setFetchMode(PDO::FETCH_ASSOC);
                    if($sql2->rowCount()>0){
                        foreach (($sql2->fetchAll()) as $key => $row3) {
                            $ca_name = $row3['firstname']. ' ' .$row3['lastname'];
                        }
                    } 
    
                    $output .= '<tr>
                        <td >'.$newDate.'</td>
                        <td>'.$row2['bmId'].'</td>
                        <td>'.$bm_name.'</td>
                        <td>'.$row2['techno_enterprise'].'</td>
                        <td>'.$ca_name.'</td>
                        <td class="message">'.$message1.'</td>
                        <td class="message">'.$message2.'</td>
                        <td style="text-align:center;">'.$Commi.'/-</td>
                        <td style="text-align:center;">'.$Commi_TDS.'/-</td>
                        <td style="text-align:center;">'.$Commi_Total.'/-</td>';
                        if($row2['status'] == 2){
                            $output .='<td style="text-align:center;">Pending</td>';
                        }else{
                            $output .='<td style="text-align:center;">Paid</td>';
                        }
                    $output .='</tr>';
                   
                }
            $output .= '</table>';
            header("Content-Type: application/xls");
            header("Content-Disposition: attachment;filename=Previous_Payout_List.xls");
            echo $output;
        }else{
            echo 'No Previous Payout Data';                                                    
        }
    } 
    
    if($payoutmessage == 'NextPayout'){
        $output="";
        $stmt2 = "SELECT id, bdm_id as bmId, message, message_details, comm_amt, techno_enterprise, created_date, status, 'goaBdm' as identity FROM `goa_bdm_payout` WHERE YEAR(created_date) = '".$payoutYear."' AND MONTH(created_date) = '".$payoutMonth."'  UNION ALL
        SELECT id, bm_id as bmId, message, message_details, comm_amt, techno_enterprise, created_date, status, 'goaBm' as identity FROM `goa_bm_payout` WHERE YEAR(created_date) = '".$payoutYear."' AND MONTH(created_date) = '".$payoutMonth."'  UNION ALL
        SELECT id, business_mentor as bmId, message, message_details, comm_amt, techno_enterprise, created_date, status, 'caPayout' as identity FROM `ca_payout` WHERE YEAR(created_date) = '".$payoutYear."' AND MONTH(created_date) = '".$payoutMonth."'  UNION ALL
        SELECT id, bm_user_id as bmId, message_bm as message, payment_message as message_details, payout_amount as comm_amt, ca_user_id as techno_enterprise, payout_date as created_date, payout_status as status, 'bmPayoutHistory' as identity FROM `bm_payout_history` WHERE YEAR(payout_date) = '".$payoutYear."' AND MONTH(payout_date) = '".$payoutMonth."' UNION ALL
        SELECT id, cte_id as bmId, cte_message as message, '' as message_details, cte_amount as comm_amt, te_id as techno_enterprise, created_date, cte_status as status, 'CTE' as identity FROM `techno_enterprise_payout` WHERE YEAR(created_date) = '".$payoutYear."' AND MONTH(created_date) = '".$payoutMonth."' UNION ALL
        SELECT id, ete_id as bmId, ete_message as message, '' as message_details, ete_amount as comm_amt, te_id as techno_enterprise, created_date, ete_status as status, 'ETE' as identity FROM `techno_enterprise_payout` WHERE YEAR(created_date) = '".$payoutYear."' AND MONTH(created_date) = '".$payoutMonth."' UNION ALL
        SELECT id, ste_id as bmId, ste_message as message, '' as message_details, ste_amount as comm_amt, te_id as techno_enterprise, created_date, ste_status as status, 'STE' as identity FROM `techno_enterprise_payout` WHERE YEAR(created_date) = '".$payoutYear."' AND MONTH(created_date) = '".$payoutMonth."' ";
    
        $stmt2 = $conn -> prepare($stmt2);
        $stmt2 -> execute();
        $stmt2 ->setFetchMode(PDO::FETCH_ASSOC);
        if($stmt2 -> rowCount()>0){
        	$output .= '<h2 style="text-align:center">Next Payout List as of '.$monthName.','.$payoutYear.'</h2>
            <table border="1" style="text-align:center">
                <tr>
                    <th >Date</th>
                    <th class="mobile_view">BDM/BM/CTE/ETE/STE</th>
                    <th class="mobile_view">BDM/BM/CTE/ETE/STE Name</th>
                    <th class="mobile_view">Techno Enterprise</th>
                    <th class="mobile_view">Techno Enterprise Name</th>
                    <th ><span class="long-name">Payout Message</th>
                    <th ><span class="long-name">Payout Details</th>
                    <th class="mobile_view tab_view">Amount</th>
                    <th class="mobile_view" >TDS</th>
                    <th style="text-align:center;">Total Payable</th>
                    <th style="text-align:center;">Status</th>
                </tr>';
                foreach($stmt2->fetchAll() as $key => $row2){
                    $rd= new DateTime($row2['created_date']);
                    $newDate= $rd->format('d-m-Y');
                    $id = $row2['id'];
    
                    // get the commission amount of BA's
                    $Commi = $row2['comm_amt'];
                    
                    (int)$Commi_TDS = (int)$Commi*2/100;
                    (int)$Commi_Total = (int)$Commi-(int)$Commi_TDS; 
    
    
                    // date in proper formate
                    $dt = new DateTime($row2['created_date']);
                    $dt = $dt->format('Y-m-d');
    
                    // replace dot at end of the line with break statement
                    $message1 = $row2['message'];
                    $message1 =  str_replace('.','<br>',$message1); 
                    $message2 = $row2['message_details'];
                    $message2 =  str_replace('.','<br>',$message2); 
    
                    $userId = $row2['bmId'];
                    $userIdty = substr($userId,0,2);
                    
                    if($userIdty == "BM"){
                        $bcNames = $conn -> prepare("SELECT firstname,lastname FROM business_mentor WHERE business_mentor_id = '".$userId."' AND status = 1");
                        $bcNames -> execute();
                        $bcNames -> setFetchMode(PDO::FETCH_ASSOC);
                        if($bcNames -> rowCount()>0){
                            foreach(($bcNames -> fetchAll()) as $key => $row1){
                                $bm_name = $row1['firstname']. ' ' .$row1['lastname'];
                            }
                        }  
                    }else if($userIdty == "BH"){
                        $bcNames = $conn -> prepare("SELECT * FROM employees WHERE employee_id = '".$userId."' AND user_type = '25' AND status = 1");
                        $bcNames -> execute();
                        $bcNames -> setFetchMode(PDO::FETCH_ASSOC);
                        if($bcNames -> rowCount()>0){
                            foreach(($bcNames -> fetchAll()) as $key => $row1){
                               $bm_name = $row1['name'];
                            }
                        }  
                    }
                    // else if($userIdty == "TE" || $userIdty == "CA"){
                    //     $bcNames = $conn -> prepare("SELECT * FROM corporate_agency WHERE corporate_agency_id = '".$userId."' AND status = 1");
                    //     $bcNames -> execute();
                    //     $bcNames -> setFetchMode(PDO::FETCH_ASSOC);
                    //     if($bcNames -> rowCount()>0){
                    //         foreach(($bcNames -> fetchAll()) as $key => $row){
                    //             $bcfirstname = $row['firstname'];
                    //             $bclastname = $row['lastname'];
                    //             $designation = "Techno Enterprise";
                    //         }
                    //     }  
                    // }
                    else if($userIdty == "CT"){
                        $bcNames = $conn -> prepare("SELECT * FROM chief_techno_enterprise WHERE chief_techno_enterprise_id = '".$userId."' AND status = 1");
                        $bcNames -> execute();
                        $bcNames -> setFetchMode(PDO::FETCH_ASSOC);
                        if($bcNames -> rowCount()>0){
                            foreach(($bcNames -> fetchAll()) as $key => $row1){
                                $bm_name = $row1['firstname']. ' ' .$row1['lastname'];
                            }
                        }  
                    }else if($userIdty == "ET"){
                        $bcNames = $conn -> prepare("SELECT * FROM executive_techno_enterprise WHERE executive_techno_enterprise_id = '".$userId."' AND status = 1");
                        $bcNames -> execute();
                        $bcNames -> setFetchMode(PDO::FETCH_ASSOC);
                        if($bcNames -> rowCount()>0){
                            foreach(($bcNames -> fetchAll()) as $key => $row1){
                                $bm_name = $row1['firstname']. ' ' .$row1['lastname'];
                            }
                        }  
                    }else if($userIdty == "ST"){
                        $bcNames = $conn -> prepare("SELECT * FROM super_techno_enterprise WHERE super_techno_enterprise_id = '".$userId."' AND status = 1");
                        $bcNames -> execute();
                        $bcNames -> setFetchMode(PDO::FETCH_ASSOC);
                        if($bcNames -> rowCount()>0){
                            foreach(($bcNames -> fetchAll()) as $key => $row1){
                                $bm_name = $row1['firstname']. ' ' .$row1['lastname'];
                            }
                        }  
                    }
                        
                    $sql2= $conn->prepare("SELECT firstname,lastname FROM `corporate_agency` where corporate_agency_id='".$row2['techno_enterprise']."'");
                    $sql2->execute();
                    $sql2->setFetchMode(PDO::FETCH_ASSOC);
                    if($sql2->rowCount()>0){
                        foreach (($sql2->fetchAll()) as $key => $row3) {
                            $ca_name = $row3['firstname']. ' ' .$row3['lastname'];
                        }
                    } 
    
                    $output .= '<tr>
                        <td >'.$newDate.'</td>
                        <td>'.$row2['bmId'].'</td>
                        <td>'.$bm_name.'</td>
                        <td>'.$row2['techno_enterprise'].'</td>
                        <td>'.$ca_name.'</td>
                        <td class="message">'.$message1.'</td>
                        <td class="message">'.$message2.'</td>
                        <td style="text-align:center;">'.$Commi.'/-</td>
                        <td style="text-align:center;">'.$Commi_TDS.'/-</td>
                        <td style="text-align:center;">'.$Commi_Total.'/-</td>';
                        if($row2['status'] == 2){
                            $output .='<td style="text-align:center;">Pending</td>';
                        }else{
                            $output .='<td style="text-align:center;">Paid</td>';
                        }
                    $output .='</tr>';
                   
                }
            $output .= '</table>';
            header("Content-Type: application/xls");
            header("Content-Disposition: attachment;filename=Next_Payout_List.xls");
            echo $output;
        }else{
            echo 'No Next Payout Data';                                                    
        }
    } 
    
    if($payoutmessage == 'TotalPayout'){
        $output="";
        $stmt2 = "SELECT id, bdm_id as bmId, message, message_details, comm_amt, techno_enterprise, created_date, status, 'goaBdm' as identity FROM `goa_bdm_payout` WHERE YEAR(created_date) = '".$payoutYear."' AND MONTH(created_date) = '".$payoutMonth."'  UNION ALL
                SELECT id, bm_id as bmId, message, message_details, comm_amt, techno_enterprise, created_date, status, 'goaBm' as identity FROM `goa_bm_payout` WHERE YEAR(created_date) = '".$payoutYear."' AND MONTH(created_date) = '".$payoutMonth."'  UNION ALL
                SELECT id, business_mentor as bmId, message, message_details, comm_amt, techno_enterprise, created_date, status, 'caPayout' as identity FROM `ca_payout` WHERE YEAR(created_date) = '".$payoutYear."' AND MONTH(created_date) = '".$payoutMonth."'  UNION ALL
                SELECT id, bm_user_id as bmId, message_bm as message, payment_message as message_details, payout_amount as comm_amt, ca_user_id as techno_enterprise, payout_date as created_date, payout_status as status, 'bmPayoutHistory' as identity FROM `bm_payout_history` WHERE YEAR(payout_date) = '".$payoutYear."' AND MONTH(payout_date) = '".$payoutMonth."' UNION ALL
                SELECT id, cte_id as bmId, cte_message as message, '' as message_details, cte_amount as comm_amt, te_id as techno_enterprise, created_date, cte_status as status, 'CTE' as identity FROM `techno_enterprise_payout` WHERE YEAR(created_date) = '".$payoutYear."' AND MONTH(created_date) = '".$payoutMonth."' UNION ALL
                SELECT id, ete_id as bmId, ete_message as message, '' as message_details, ete_amount as comm_amt, te_id as techno_enterprise, created_date, ete_status as status, 'ETE' as identity FROM `techno_enterprise_payout` WHERE YEAR(created_date) = '".$payoutYear."' AND MONTH(created_date) = '".$payoutMonth."' UNION ALL
                SELECT id, ste_id as bmId, ste_message as message, '' as message_details, ste_amount as comm_amt, te_id as techno_enterprise, created_date, ste_status as status, 'STE' as identity FROM `techno_enterprise_payout` WHERE YEAR(created_date) = '".$payoutYear."' AND MONTH(created_date) = '".$payoutMonth."'";
    
        $stmt2 = $conn -> prepare($stmt2);
        $stmt2 -> execute();
        $stmt2 ->setFetchMode(PDO::FETCH_ASSOC);
        if($stmt2 -> rowCount()>0){
        	$output .= '<h2 style="text-align:center">Total Payout List as of '.$monthName.','.$payoutYear.'</h2>
            <table border="1" style="text-align:center">
                <tr>
                    <th >Date</th>
                    <th class="mobile_view">BDM/BM/CTE/ETE/STE</th>
                    <th class="mobile_view">BDM/BM/CTE/ETE/STE Name</th>
                    <th class="mobile_view">Techno Enterprise</th>
                    <th class="mobile_view">Techno Enterprise Name</th>
                    <th ><span class="long-name">Payout Message</th>
                    <th ><span class="long-name">Payout Details</th>
                    <th class="mobile_view tab_view">Amount</th>
                    <th class="mobile_view" >TDS</th>
                    <th style="text-align:center;">Total Payable</th>
                    <th style="text-align:center;">Status</th>
                </tr>';
                foreach($stmt2->fetchAll() as $key => $row2){
                    $rd= new DateTime($row2['created_date']);
                    $newDate= $rd->format('d-m-Y');
                    $id = $row2['id'];
    
                    // get the commission amount of BA's
                    $Commi = $row2['comm_amt'];
                    
                    (int)$Commi_TDS = (int)$Commi*2/100;
                    (int)$Commi_Total = (int)$Commi-(int)$Commi_TDS; 
    
    
                    // date in proper formate
                    $dt = new DateTime($row2['created_date']);
                    $dt = $dt->format('Y-m-d');
    
                    // replace dot at end of the line with break statement
                    $message1 = $row2['message'];
                    $message1 =  str_replace('.','<br>',$message1); 
                    $message2 = $row2['message_details'];
                    $message2 =  str_replace('.','<br>',$message2); 
    
                    $userId = $row2['bmId'];
                    $userIdty = substr($userId,0,2);
                    
                    if($userIdty == "BM"){
                        $bcNames = $conn -> prepare("SELECT firstname,lastname FROM business_mentor WHERE business_mentor_id = '".$userId."' AND status = 1");
                        $bcNames -> execute();
                        $bcNames -> setFetchMode(PDO::FETCH_ASSOC);
                        if($bcNames -> rowCount()>0){
                            foreach(($bcNames -> fetchAll()) as $key => $row1){
                                $bm_name = $row1['firstname']. ' ' .$row1['lastname'];
                            }
                        }  
                    }else if($userIdty == "BH"){
                        $bcNames = $conn -> prepare("SELECT * FROM employees WHERE employee_id = '".$userId."' AND user_type = '25' AND status = 1");
                        $bcNames -> execute();
                        $bcNames -> setFetchMode(PDO::FETCH_ASSOC);
                        if($bcNames -> rowCount()>0){
                            foreach(($bcNames -> fetchAll()) as $key => $row1){
                               $bm_name = $row1['name'];
                            }
                        }  
                    }
                    // else if($userIdty == "TE" || $userIdty == "CA"){
                    //     $bcNames = $conn -> prepare("SELECT * FROM corporate_agency WHERE corporate_agency_id = '".$userId."' AND status = 1");
                    //     $bcNames -> execute();
                    //     $bcNames -> setFetchMode(PDO::FETCH_ASSOC);
                    //     if($bcNames -> rowCount()>0){
                    //         foreach(($bcNames -> fetchAll()) as $key => $row){
                    //             $bcfirstname = $row['firstname'];
                    //             $bclastname = $row['lastname'];
                    //             $designation = "Techno Enterprise";
                    //         }
                    //     }  
                    // }
                    else if($userIdty == "CT"){
                        $bcNames = $conn -> prepare("SELECT * FROM chief_techno_enterprise WHERE chief_techno_enterprise_id = '".$userId."' AND status = 1");
                        $bcNames -> execute();
                        $bcNames -> setFetchMode(PDO::FETCH_ASSOC);
                        if($bcNames -> rowCount()>0){
                            foreach(($bcNames -> fetchAll()) as $key => $row1){
                                $bm_name = $row1['firstname']. ' ' .$row1['lastname'];
                            }
                        }  
                    }else if($userIdty == "ET"){
                        $bcNames = $conn -> prepare("SELECT * FROM executive_techno_enterprise WHERE executive_techno_enterprise_id = '".$userId."' AND status = 1");
                        $bcNames -> execute();
                        $bcNames -> setFetchMode(PDO::FETCH_ASSOC);
                        if($bcNames -> rowCount()>0){
                            foreach(($bcNames -> fetchAll()) as $key => $row1){
                                $bm_name = $row1['firstname']. ' ' .$row1['lastname'];
                            }
                        }  
                    }else if($userIdty == "ST"){
                        $bcNames = $conn -> prepare("SELECT * FROM super_techno_enterprise WHERE super_techno_enterprise_id = '".$userId."' AND status = 1");
                        $bcNames -> execute();
                        $bcNames -> setFetchMode(PDO::FETCH_ASSOC);
                        if($bcNames -> rowCount()>0){
                            foreach(($bcNames -> fetchAll()) as $key => $row1){
                                $bm_name = $row1['firstname']. ' ' .$row1['lastname'];
                            }
                        }  
                    } 
    
                    $sql2= $conn->prepare("SELECT firstname,lastname FROM `corporate_agency` where corporate_agency_id='".$row2['techno_enterprise']."'");
                    $sql2->execute();
                    $sql2->setFetchMode(PDO::FETCH_ASSOC);
                    if($sql2->rowCount()>0){
                        foreach (($sql2->fetchAll()) as $key => $row3) {
                            $ca_name = $row3['firstname']. ' ' .$row3['lastname'];
                        }
                    } 
    
                    $output .= '<tr>
                        <td >'.$newDate.'</td>
                        <td>'.$row2['bmId'].'</td>
                        <td>'.$bm_name.'</td>
                        <td>'.$row2['techno_enterprise'].'</td>
                        <td>'.$ca_name.'</td>
                        <td class="message">'.$message1.'</td>
                        <td class="message">'.$message2.'</td>
                        <td style="text-align:center;">'.$Commi.'/-</td>
                        <td style="text-align:center;">'.$Commi_TDS.'/-</td>
                        <td style="text-align:center;">'.$Commi_Total.'/-</td>';
                        if($row2['status'] == 2){
                            $output .='<td style="text-align:center;">Pending</td>';
                        }else{
                            $output .='<td style="text-align:center;">Paid</td>';
                        }
                    $output .='</tr>';
                   
                }
            $output .= '</table>';
            header("Content-Type: application/xls");
            header("Content-Disposition: attachment;filename=Total_Payout_List.xls");
            echo $output;
        }else{
            echo 'No Total Payout Data';                                                    
        }
    }
    
    if($payoutmessage == 'allPayout'){
    
        if($designation == 'business_development_manager'){
            $stmt2 = "SELECT id, bdm_id as bmId, message, message_details, comm_amt, techno_enterprise, created_date, status, 'goaBdm' as identity FROM goa_bdm_payout WHERE bdm_id = '".$user_id."' AND YEAR(created_date) = '".$payoutYear."' AND MONTH(created_date) = '".$payoutMonth."' ";
        }else if($designation == 'business_mentor'){
            $stmt2 = "SELECT id, bm_id as bmId, message, message_details, comm_amt, techno_enterprise, created_date, status, 'goaBm' as identity FROM `goa_bm_payout` WHERE bm_id = '".$user_id."' AND YEAR(created_date) = '".$payoutYear."' AND MONTH(created_date) = '".$payoutMonth."' UNION ALL
                    SELECT id, business_mentor as bmId, message, message_details, comm_amt, techno_enterprise, created_date, status, 'caPayout' as identity FROM `ca_payout`  WHERE business_mentor = '".$user_id."' AND YEAR(created_date) = '".$payoutYear."' AND MONTH(created_date) = '".$payoutMonth."' UNION ALL
                    SELECT id, bm_user_id as bmId, message_bm as message, payment_message as message_details, payout_amount as comm_amt, ca_user_id as techno_enterprise, payout_date as created_date, payout_status as status, 'bmPayoutHistory' as identity FROM `bm_payout_history` WHERE bm_user_id = '".$user_id."' AND YEAR(payout_date) = '".$payoutYear."' AND MONTH(payout_date) = '".$payoutMonth."' ";
        }else if($designation == 'corporate_agency'){
            $stmt2 = "SELECT id, bdm_id as bmId, message, message_details, comm_amt, techno_enterprise, created_date, status, 'goaBdm' as identity FROM `goa_bdm_payout` WHERE techno_enterprise = '".$user_id."' AND YEAR(created_date) = '".$payoutYear."' AND MONTH(created_date) = '".$payoutMonth."' UNION ALL
                    SELECT id, bm_id as bmId, message, message_details, comm_amt, techno_enterprise, created_date, status, 'goaBm' as identity FROM `goa_bm_payout` WHERE techno_enterprise = '".$user_id."' AND YEAR(created_date) = '".$payoutYear."' AND MONTH(created_date) = '".$payoutMonth."' UNION ALL
                    SELECT id, business_mentor as bmId, message, message_details, comm_amt, techno_enterprise, created_date, status, 'caPayout' as identity FROM `ca_payout` WHERE techno_enterprise = '".$user_id."' AND YEAR(created_date) = '".$payoutYear."' AND MONTH(created_date) = '".$payoutMonth."' UNION ALL
                    SELECT id, bm_user_id as bmId, message_bm as message, payment_message as message_details, payout_amount as comm_amt, ca_user_id as techno_enterprise, payout_date as created_date, payout_status as status, 'bmPayoutHistory' as identity FROM `bm_payout_history` WHERE ca_user_id = '".$user_id."' AND YEAR(payout_date) = '".$payoutYear."' AND MONTH(payout_date) = '".$payoutMonth."' ";
        }else if($designation == 'chief_techno_enterprise'){

            $stmt2 = "SELECT id, cte_id as bmId, cte_message as message, '' as message_details, cte_amount as comm_amt, te_id as techno_enterprise, created_date, cte_status as status, 'Chief Techno Enterprise' as identity FROM techno_enterprise_payout WHERE cte_id = '".$user_id."' AND YEAR(created_date) = '".$payoutYear."' AND MONTH(created_date) = '".$payoutMonth."' order by created_date DESC";

        }else if($designation == 'executive_techno_enterprise'){

            $stmt2 = "SELECT id, ete_id as bmId, ete_message as message, '' as message_details, ete_amount as comm_amt, te_id as techno_enterprise, created_date, ete_status as status, 'executive Techno Enterprise' as identity FROM techno_enterprise_payout WHERE ete_id = '".$user_id."' AND YEAR(created_date) = '".$payoutYear."' AND MONTH(created_date) = '".$payoutMonth."' order by created_date DESC";

        }else if($designation == 'super_techno_enterprise'){

            $stmt2 = "SELECT id, ste_id as bmId, ste_message as message, '' as message_details, ste_amount as comm_amt, te_id as techno_enterprise, created_date, ste_status as status, 'Super Techno Enterprise' as identity FROM techno_enterprise_payout WHERE ste_id = '".$user_id."' AND YEAR(created_date) = '".$payoutYear."' AND MONTH(created_date) = '".$payoutMonth."' order by created_date DESC";

        }
    
        $output="";
       
        $stmt2 = $conn -> prepare($stmt2);
        $stmt2 -> execute();
        $stmt2 ->setFetchMode(PDO::FETCH_ASSOC);
        if($stmt2 -> rowCount()>0){
        	$output .= '<h2 style="text-align:center">All Payout List as of '.$monthName.','.$payoutYear.'</h2>
            <table border="1" style="text-align:center">
                <tr>
                    <th >Date</th>
                    <th class="mobile_view">BDM/BM/CTE/ETE/STE</th>
                    <th class="mobile_view">BDM/BM/CTE/ETE/STE Name</th>
                    <th class="mobile_view">Techno Enterprise</th>
                    <th class="mobile_view">Techno Enterprise Name</th>
                    <th ><span class="long-name">Payout Message</th>
                    <th ><span class="long-name">Payout Details</th>
                    <th class="mobile_view tab_view">Amount</th>
                    <th class="mobile_view" >TDS</th>
                    <th style="text-align:center;">Total Payable</th>
                    <th style="text-align:center;">Status</th>
                </tr>';
                foreach($stmt2->fetchAll() as $key => $row2){
                    $rd= new DateTime($row2['created_date']);
                    $newDate= $rd->format('d-m-Y');
                    $id = $row2['id'];
    
                    // get the commission amount of BA's
                    $Commi = $row2['comm_amt'];
                    
                    (int)$Commi_TDS = (int)$Commi*2/100;
                    (int)$Commi_Total = (int)$Commi-(int)$Commi_TDS; 
    
    
                    // date in proper formate
                    $dt = new DateTime($row2['created_date']);
                    $dt = $dt->format('Y-m-d');
    
                    // replace dot at end of the line with break statement
                    $message1 = $row2['message'];
                    $message1 =  str_replace('.','<br>',$message1); 
                    $message2 = $row2['message_details'];
                    $message2 =  str_replace('.','<br>',$message2); 
    
                    $userId = $row2['bmId'];
                    $userIdty = substr($userId,0,2);
                    
                    if($userIdty == "BM"){
                        $bcNames = $conn -> prepare("SELECT firstname,lastname FROM business_mentor WHERE business_mentor_id = '".$userId."' AND status = 1");
                        $bcNames -> execute();
                        $bcNames -> setFetchMode(PDO::FETCH_ASSOC);
                        if($bcNames -> rowCount()>0){
                            foreach(($bcNames -> fetchAll()) as $key => $row1){
                                $bm_name = $row1['firstname']. ' ' .$row1['lastname'];
                            }
                        }  
                    }else if($userIdty == "BH"){
                        $bcNames = $conn -> prepare("SELECT * FROM employees WHERE employee_id = '".$userId."' AND user_type = '25' AND status = 1");
                        $bcNames -> execute();
                        $bcNames -> setFetchMode(PDO::FETCH_ASSOC);
                        if($bcNames -> rowCount()>0){
                            foreach(($bcNames -> fetchAll()) as $key => $row1){
                               $bm_name = $row1['name'];
                            }
                        }  
                    }
                    // else if($userIdty == "TE" || $userIdty == "CA"){
                    //     $bcNames = $conn -> prepare("SELECT * FROM corporate_agency WHERE corporate_agency_id = '".$userId."' AND status = 1");
                    //     $bcNames -> execute();
                    //     $bcNames -> setFetchMode(PDO::FETCH_ASSOC);
                    //     if($bcNames -> rowCount()>0){
                    //         foreach(($bcNames -> fetchAll()) as $key => $row){
                    //             $bcfirstname = $row['firstname'];
                    //             $bclastname = $row['lastname'];
                    //             $designation = "Techno Enterprise";
                    //         }
                    //     }  
                    // }
                    else if($userIdty == "CT"){
                        $bcNames = $conn -> prepare("SELECT * FROM chief_techno_enterprise WHERE chief_techno_enterprise_id = '".$userId."' AND status = 1");
                        $bcNames -> execute();
                        $bcNames -> setFetchMode(PDO::FETCH_ASSOC);
                        if($bcNames -> rowCount()>0){
                            foreach(($bcNames -> fetchAll()) as $key => $row1){
                                $bm_name = $row1['firstname']. ' ' .$row1['lastname'];
                            }
                        }  
                    }else if($userIdty == "ET"){
                        $bcNames = $conn -> prepare("SELECT * FROM executive_techno_enterprise WHERE executive_techno_enterprise_id = '".$userId."' AND status = 1");
                        $bcNames -> execute();
                        $bcNames -> setFetchMode(PDO::FETCH_ASSOC);
                        if($bcNames -> rowCount()>0){
                            foreach(($bcNames -> fetchAll()) as $key => $row1){
                                $bm_name = $row1['firstname']. ' ' .$row1['lastname'];
                            }
                        }  
                    }else if($userIdty == "ST"){
                        $bcNames = $conn -> prepare("SELECT * FROM super_techno_enterprise WHERE super_techno_enterprise_id = '".$userId."' AND status = 1");
                        $bcNames -> execute();
                        $bcNames -> setFetchMode(PDO::FETCH_ASSOC);
                        if($bcNames -> rowCount()>0){
                            foreach(($bcNames -> fetchAll()) as $key => $row1){
                                $bm_name = $row1['firstname']. ' ' .$row1['lastname'];
                            }
                        }  
                    } 
    
                    $sql2= $conn->prepare("SELECT firstname,lastname FROM `corporate_agency` where corporate_agency_id='".$row2['techno_enterprise']."'");
                    $sql2->execute();
                    $sql2->setFetchMode(PDO::FETCH_ASSOC);
                    if($sql2->rowCount()>0){
                        foreach (($sql2->fetchAll()) as $key => $row3) {
                            $ca_name = $row3['firstname']. ' ' .$row3['lastname'];
                        }
                    } 
    
                    $output .= '<tr>
                        <td >'.$newDate.'</td>
                        <td>'.$row2['bmId'].'</td>
                        <td>'.$bm_name.'</td>
                        <td>'.$row2['techno_enterprise'].'</td>
                        <td>'.$ca_name.'</td>
                        <td class="message">'.$message1.'</td>
                        <td class="message">'.$message2.'</td>
                        <td style="text-align:center;">'.$Commi.'/-</td>
                        <td style="text-align:center;">'.$Commi_TDS.'/-</td>
                        <td style="text-align:center;">'.$Commi_Total.'/-</td>';
                        if($row2['status'] == 2){
                            $output .='<td style="text-align:center;">Pending</td>';
                        }else{
                            $output .='<td style="text-align:center;">Paid</td>';
                        }
                    $output .='</tr>';
                   
                }
            $output .= '</table>';
            header("Content-Type: application/xls");
            header("Content-Disposition: attachment;filename=All_Payout_List.xls");
            echo $output;
        }else{
            echo 'No Previous Payout Data';                                                    
        }
    }

?>