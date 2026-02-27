<?php
require '../../../connect.php';
$payoutYear = $_GET['payoutYear'];
$payoutMonth = $_GET['payoutMonth'];
$payoutmessage = $_GET['payoutmessage'];
$designation = $_GET['designation'] ?? '';
$user_id = $_GET['user_id'] ?? '';
$user_id_str=substr($user_id,0,1) == 'F'?substr($user_id,0,1):substr($user_id,0,2);

$dateObj   = DateTime::createFromFormat('!m', $payoutMonth);
$monthName = $dateObj->format('F'); 

if($payoutmessage == 'PreviousPayout'){
    $output="";
    // $stmt2 = "SELECT * FROM ca_cu_payout WHERE $designation = '".$user_id."' AND YEAR(created_date) = '".$payoutYear."' AND MONTH(created_date) = '".$payoutMonth."' ";
    $stmt2 = "SELECT 
                    ca.created_date,
                    ca.status,
                    ca.id,
                    ca.business_mentor,
                    ca.message_bm,
                    ca.commision_bm,
                    ca.status_bm,
                    ca.techno_enterprise,
                    ca.message_te,
                    ca.commision_te,
                    ca.status_te,
                    ca.travel_consultant,
                    ca.message_tc,
                    ca.commision_tc,
                    ca.status_tc,
                    COALESCE(cap.status, 0) AS status,
                    cap.date AS paydate
                FROM ca_cu_payout ca
                LEFT JOIN ca_cu_payout_paid cap 
                    ON cap.$designation = ca.$designation
                    AND cap.travel_consultant = ca.travel_consultant
                    AND YEAR(cap.date) = '".$payoutYear."'
                    AND MONTH(cap.date) = '".$payoutMonth."'
                WHERE ca.$designation = '".$user_id."' 
                AND YEAR(ca.created_date) = '".$payoutYear."' 
                AND MONTH(ca.created_date) = '".$payoutMonth."'
                ";
    $stmt2 = $conn -> prepare($stmt2);
    $stmt2 -> execute();
    $stmt2 ->setFetchMode(PDO::FETCH_ASSOC);
    if($stmt2 -> rowCount()>0){
    	$output .= '<h2 style="text-align:center">Previous Payout List as of '.$monthName.','.$payoutYear.'</h2>
        <table border="1" style="text-align:center">
             <tr>
                <th >Date</th>';
                
                if($user_id_str == "BM"){
                    $output .= '<th class="mobile_view">Business Mentor</th>
                    <th class="mobile_view">Business Mentor Name</th>';
                }else if($user_id_str == "TE" || $user_id_str == "CA"){
                    $output .= '<th class="mobile_view">Techno Enterprise</th>
                    <th class="mobile_view">Techno Enterprise Name</th>';
                }else if($user_id_str == "SF"){
                    $output .= '<th class="mobile_view">Sponsor Franchisee</th>
                    <th class="mobile_view">Sponsor Franchisee Name</th>';
                }else if($user_id_str == "MF"){
                    $output .= '<th class="mobile_view">Master Franchisee</th>
                    <th class="mobile_view">Master Franchisee Name</th>';
                }else if($user_id_str == "F"){
                    $output .= '<th class="mobile_view">Franchisee</th>
                    <th class="mobile_view">Franchisee Name</th>';
                }else if($user_id_str == "TA"){
                    $output .= '<th class="mobile_view">Travel Agency</th>
                    <th class="mobile_view">Franchisee Name</th>';
                }

                $output .= '<th ><span class="long-name">Payout Details</th>
                <th class="mobile_view tab_view">Amount</th>
                <th class="mobile_view" >TDS</th>
                <th style="text-align:center;">Total Payable</th>
                <th style="text-align:center;">Status</th>
                <th style="text-align:center;">Paid Date</th>
            </tr>';
            foreach($stmt2->fetchAll() as $key => $row2){
                $rd= new DateTime($row2['created_date']);
                $newDate= $rd->format('d-m-Y');
                $id = $row2['id'];

                if($user_id_str == "BM" || $user_id_str == "SF" || $user_id_str == "MF"){

                    $BC_Commi = $row2['commision_bm'];
                
                    (int)$BC_Commi_TDS = (int)$BC_Commi*2/100;
                    (int)$BC_Commi_Total = (int)$BC_Commi-(int)$BC_Commi_TDS; 

                    // date in proper formate
                    $dt = new DateTime($row2['created_date']);
                    $dt = $dt->format('Y-m-d');

                    // replace dot at end of the line with break statement
                    $message1 = $row2['message_bm'];
                    $message1 =  str_replace('.','<br>',$message1); 
                    if($user_id_str == "SF"){
                        $sql1= $conn->prepare("SELECT firstname,lastname FROM `sponsor_franchisee` where sponsor_franchisee_id='".$row2['business_mentor']."'");
                    }else if($user_id_str == "MF"){
                        $sql1= $conn->prepare("SELECT firstname,lastname FROM `master_franchisee` where master_franchisee_id='".$row2['business_mentor']."'");
                    }else{
                        $sql1= $conn->prepare("SELECT firstname,lastname FROM `business_mentor` where business_mentor_id='".$row2['business_mentor']."'");
                    }
                    $sql1->execute();
                    $sql1->setFetchMode(PDO::FETCH_ASSOC);
                    if($sql1->rowCount()>0){
                        foreach (($sql1->fetchAll()) as $key => $row1) {
                            $ta_name = $row1['firstname']. ' ' .$row1['lastname'];
                        }
                    } 

                    $output .= '<tr>
                        <td >'.$newDate.'</td>
                        <td>'.$row2['business_mentor'].'</td>
                        <td>'.$ta_name.'</td>
                        <td class="message">'.$message1.'</td>
                        <td style="text-align:center;">'.$BC_Commi.'</td>
                        <td style="text-align:center;">'.$BC_Commi_TDS.'/-</td>
                        <td style="text-align:center;">'.$BC_Commi_Total.'/-</td>';
                        if($row2['status_bm'] == 2){
                            $output .='<td style="text-align:center;">Pending</td>
                                       <td style="text-align:center;">NA</td>';
                        }else if($row2['status_bm'] == 1){
                            $output .='<td style="text-align:center;">Paid</td>
                                       <td style="text-align:center;">'.$row2["paydate"].'</td>';
                        }
                    $output .='</tr>';
                }else if($user_id_str == "TE" || $user_id_str == "CA"|| $user_id_str == "F"){

                    $CA_Commi = $row2['commision_te'];

                    (int)$CA_Commi_TDS = (int)$CA_Commi*2/100;
                    (int)$CA_Commi_Total = (int)$CA_Commi-(int)$CA_Commi_TDS; 

                    $message2 = $row2['message_te'];
                    $message2 =  str_replace('.','<br>',$message2); 
                    if($user_id_str == "TE" || $user_id_str == "CA"){
                        $sql2= $conn->prepare("SELECT firstname,lastname FROM `corporate_agency` where corporate_agency_id='".$row2['techno_enterprise']."'");
                    }else if($user_id_str == "F"){
                        $sql2= $conn->prepare("SELECT firstname,lastname FROM `sub_franchisee` where sub_franchisee_id='".$row2['techno_enterprise']."'");
                    }
                    $sql2->execute();
                    $sql2->setFetchMode(PDO::FETCH_ASSOC);
                    if($sql2->rowCount()>0){
                        foreach (($sql2->fetchAll()) as $key => $row3) {
                            $ca_name = $row3['firstname']. ' ' .$row3['lastname'];
                        }
                    } 
                    
                    $output .='<tr>
                        <td >'.$newDate.'</td>
                        <td>'.$row2['techno_enterprise'].'</td>
                        <td>'.$ca_name.'</td>
                        <td >'.$message2.'</td>
                        <td style="text-align:center;">'.$CA_Commi.'</td>
                        <td style="text-align:center;">'.$CA_Commi_TDS.'/-</td>
                        <td style="text-align:center;">'.$CA_Commi_Total.'/-</td>';
                        if($row2['status_te'] == 2){
                            $output .= '<td style="text-align:center;">Pending</td>
                                        <td style="text-align:center;">NA</td>';
                        }else if($row2['status_te'] == 1){
                            $output .= '<td style="text-align:center;">Paid</td>
                                        <td style="text-align:center;">'.$row2["paydate"].'</td>';
                        }
                    $output .='</tr>';
                }else if($user_id_str == "TA"){

                    $CA_Commi = $row2['commision_tc'];

                    (int)$CA_Commi_TDS = (int)$CA_Commi*2/100;
                    (int)$CA_Commi_Total = (int)$CA_Commi-(int)$CA_Commi_TDS; 

                    $message2 = $row2['message_tc'];
                    $message2 =  str_replace('.','<br>',$message2); 
                    if($user_id_str == "TA"){
                        $sql1= $conn->prepare("SELECT firstname,lastname FROM `ca_travelagency` where ca_travelagency_id='".$row2['travel_consultant']."'");
                    }
                    $sql2->execute();
                    $sql2->setFetchMode(PDO::FETCH_ASSOC);
                    if($sql2->rowCount()>0){
                        foreach (($sql2->fetchAll()) as $key => $row3) {
                            $ca_name = $row3['firstname']. ' ' .$row3['lastname'];
                        }
                    } 
                    
                    $output .='<tr>
                        <td >'.$newDate.'</td>
                        <td>'.$row2['travel_consultant'].'</td>
                        <td>'.$ca_name.'</td>
                        <td >'.$message2.'</td>
                        <td style="text-align:center;">'.$CA_Commi.'</td>
                        <td style="text-align:center;">'.$CA_Commi_TDS.'/-</td>
                        <td style="text-align:center;">'.$CA_Commi_Total.'/-</td>';
                        if($row2['status_tc'] == 2){
                            $output .= '<td style="text-align:center;">Pending</td>
                                        <td style="text-align:center;">NA</td>';
                        }else if($row2['status_tc'] == 1){
                            $output .= '<td style="text-align:center;">Paid</td>
                                        <td style="text-align:center;">'.$row2["paydate"].'</td>';
                        }
                    $output .='</tr>';
                }
            
            }
        $output .= '</table>';
        header("Content-Type: application/xls");
        header("Content-Disposition: attachment;filename=Previous_Payout_List.xls");
        echo $output;
    }else{
        echo '<script>alert("No Payout Data"); window.history.back();</script>';                                                   
    }
} 

if($payoutmessage == 'NextPayout'){
    $output="";
    // $stmt2 = "SELECT * FROM ca_cu_payout WHERE $designation = '".$user_id."' AND YEAR(created_date) = '".$payoutYear."' AND MONTH(created_date) = '".$payoutMonth."' ";
    $stmt2 ="SELECT 
                    ca.created_date,
                    ca.status,
                    ca.id,
                    ca.business_mentor,
                    ca.message_bm,
                    ca.commision_bm,
                    ca.status_bm,
                    ca.techno_enterprise,
                    ca.message_te,
                    ca.commision_te,
                    ca.status_te,
                    ca.travel_consultant,
                    ca.message_tc,
                    ca.commision_tc,
                    ca.status_tc,
                    COALESCE(cap.status, 0) AS status,
                    cap.date AS paydate
                FROM ca_cu_payout ca
                LEFT JOIN ca_cu_payout_paid cap 
                    ON cap.$designation = ca.$designation
                    AND cap.travel_consultant = ca.travel_consultant
                    AND YEAR(cap.date) = '".$payoutYear."'
                    AND MONTH(cap.date) = '".$payoutMonth."'
                WHERE ca.$designation = '".$user_id."' 
                AND YEAR(ca.created_date) = '".$payoutYear."' 
                AND MONTH(ca.created_date) = '".$payoutMonth."'";
    $stmt2 = $conn -> prepare($stmt2);
    $stmt2 -> execute();
    $stmt2 ->setFetchMode(PDO::FETCH_ASSOC);
    if($stmt2 -> rowCount()>0){
    	$output .= '<h2 style="text-align:center">Next Payout List as of '.$monthName.','.$payoutYear.'</h2>
        <table border="1" style="text-align:center">
            <tr>
                <th >Date</th>';
                
               if($user_id_str == "BM"){
                    $output .= '<th class="mobile_view">Business Mentor</th>
                    <th class="mobile_view">Business Mentor Name</th>';
                }else if($user_id_str == "TE" || $user_id_str == "CA"){
                    $output .= '<th class="mobile_view">Techno Enterprise</th>
                    <th class="mobile_view">Techno Enterprise Name</th>';
                }else if($user_id_str == "SF"){
                    $output .= '<th class="mobile_view">Sponsor Franchisee</th>
                    <th class="mobile_view">Sponsor Franchisee Name</th>';
                }else if($user_id_str == "MF"){
                    $output .= '<th class="mobile_view">Master Franchisee</th>
                    <th class="mobile_view">Master Franchisee Name</th>';
                }else if($user_id_str == "F"){
                    $output .= '<th class="mobile_view">Franchisee</th>
                    <th class="mobile_view">Franchisee Name</th>';
                }else if($user_id_str == "TA"){
                    $output .= '<th class="mobile_view">Travel Agency</th>
                    <th class="mobile_view">Travel Agency Name</th>';
                }

                $output .= '<th ><span class="long-name">Payout Details</th>
                <th class="mobile_view tab_view">Amount</th>
                <th class="mobile_view" >TDS</th>
                <th style="text-align:center;">Total Payable</th>
                <th style="text-align:center;">Status</th>
                <th style="text-align:center;">Paid Date</th>
            </tr>';
            foreach($stmt2->fetchAll() as $key => $row2){
                $rd= new DateTime($row2['created_date']);
                $newDate= $rd->format('d-m-Y');
                $id = $row2['id'];

                if($user_id_str == "BM" || $user_id_str == "SF" || $user_id_str == "MF"){

                    $BC_Commi = $row2['commision_bm'];
                
                    (int)$BC_Commi_TDS = (int)$BC_Commi*2/100;
                    (int)$BC_Commi_Total = (int)$BC_Commi-(int)$BC_Commi_TDS; 

                    // date in proper formate
                    $dt = new DateTime($row2['created_date']);
                    $dt = $dt->format('Y-m-d');

                    // replace dot at end of the line with break statement
                    $message1 = $row2['message_bm'];
                    $message1 =  str_replace('.','<br>',$message1); 
                    
                    if($user_id_str == "SF"){
                        $sql1= $conn->prepare("SELECT firstname,lastname FROM `sponsor_franchisee` where sponsor_franchisee_id='".$row2['business_mentor']."'");
                    }else if($user_id_str == "MF"){
                        $sql1= $conn->prepare("SELECT firstname,lastname FROM `master_franchisee` where master_franchisee_id='".$row2['business_mentor']."'");
                    }else{
                        $sql1= $conn->prepare("SELECT firstname,lastname FROM `business_mentor` where business_mentor_id='".$row2['business_mentor']."'");
                    }
                    $sql1->execute();
                    $sql1->setFetchMode(PDO::FETCH_ASSOC);
                    if($sql1->rowCount()>0){
                        foreach (($sql1->fetchAll()) as $key => $row1) {
                            $ta_name = $row1['firstname']. ' ' .$row1['lastname'];
                        }
                    } 

                    $output .= '<tr>
                        <td >'.$newDate.'</td>
                        <td>'.$row2['business_mentor'].'</td>
                        <td>'.$ta_name.'</td>
                        <td class="message">'.$message1.'</td>
                        <td style="text-align:center;">'.$BC_Commi.'</td>
                        <td style="text-align:center;">'.$BC_Commi_TDS.'/-</td>
                        <td style="text-align:center;">'.$BC_Commi_Total.'/-</td>';
                        if($row2['status_bm'] == 2){
                            $output .='<td style="text-align:center;">Pending</td>
                                       <td style="text-align:center;">NA</td>';
                        }else if($row2['status_bm'] == 1){
                            $output .='<td style="text-align:center;">Paid</td>
                                       <td style="text-align:center;">'.$row2["paydate"].'</td>';
                        }
                    $output .='</tr>';
                }elseif($user_id_str == "TE" || $user_id_str == "CA"|| $user_id_str == "F"){

                    $CA_Commi = $row2['commision_te'];

                    (int)$CA_Commi_TDS = (int)$CA_Commi*2/100;
                    (int)$CA_Commi_Total = (int)$CA_Commi-(int)$CA_Commi_TDS; 

                    $message2 = $row2['message_te'];
                    $message2 =  str_replace('.','<br>',$message2); 

                    if($user_id_str == "TE" || $user_id_str == "CA"){
                        $sql2= $conn->prepare("SELECT firstname,lastname FROM `corporate_agency` where corporate_agency_id='".$row2['techno_enterprise']."'");
                    }else if($user_id_str == "F"){
                        $sql2= $conn->prepare("SELECT firstname,lastname FROM `sub_franchisee` where sub_franchisee_id='".$row2['techno_enterprise']."'");
                    }
                    $sql2->execute();
                    $sql2->setFetchMode(PDO::FETCH_ASSOC);
                    if($sql2->rowCount()>0){
                        foreach (($sql2->fetchAll()) as $key => $row3) {
                            $ca_name = $row3['firstname']. ' ' .$row3['lastname'];
                        }
                    } 
                    
                    $output .='<tr>
                        <td >'.$newDate.'</td>
                        <td>'.$row2['techno_enterprise'].'</td>
                        <td>'.$ca_name.'</td>
                        <td >'.$message2.'</td>
                        <td style="text-align:center;">'.$CA_Commi.'</td>
                        <td style="text-align:center;">'.$CA_Commi_TDS.'/-</td>
                        <td style="text-align:center;">'.$CA_Commi_Total.'/-</td>';
                        if($row2['status_te'] == 2){
                            $output .= '<td style="text-align:center;">Pending</td>
                                        <td style="text-align:center;">NA</td>';
                        }else if($row2['status_te'] == 1){
                            $output .= '<td style="text-align:center;">Paid</td>
                                        <td style="text-align:center;">'.$row2["paydate"].'</td>';
                        }
                    $output .='</tr>';
                }elseif($user_id_str == "TA"){

                    $CA_Commi = $row2['commision_tc'];

                    (int)$CA_Commi_TDS = (int)$CA_Commi*2/100;
                    (int)$CA_Commi_Total = (int)$CA_Commi-(int)$CA_Commi_TDS; 

                    $message2 = $row2['message_tc'];
                    $message2 =  str_replace('.','<br>',$message2); 

                    if($user_id_str == "TA"){
                        $sql2= $conn->prepare("SELECT firstname,lastname FROM `ca_travelagency` where ca_travelagency_id='".$row2['travel_consultant']."'");
                    }
                    $sql2->execute();
                    $sql2->setFetchMode(PDO::FETCH_ASSOC);
                    if($sql2->rowCount()>0){
                        foreach (($sql2->fetchAll()) as $key => $row3) {
                            $ca_name = $row3['firstname']. ' ' .$row3['lastname'];
                        }
                    } 
                    
                    $output .='<tr>
                        <td >'.$newDate.'</td>
                        <td>'.$row2['travel_consultant'].'</td>
                        <td>'.$ca_name.'</td>
                        <td >'.$message2.'</td>
                        <td style="text-align:center;">'.$CA_Commi.'</td>
                        <td style="text-align:center;">'.$CA_Commi_TDS.'/-</td>
                        <td style="text-align:center;">'.$CA_Commi_Total.'/-</td>';
                        if($row2['status_tc'] == 2){
                            $output .= '<td style="text-align:center;">Pending</td>
                                        <td style="text-align:center;">NA</td>';
                        }else if($row2['status_tc'] == 1){
                            $output .= '<td style="text-align:center;">Paid</td>
                                        <td style="text-align:center;">'.$row2["paydate"].'</td>';
                        }
                    $output .='</tr>';
                }
            }
        $output .= '</table>';
        header("Content-Type: application/xls");
        header("Content-Disposition: attachment;filename=Next_Payout_List.xls");
        echo $output;
    }else{
        echo '<script>alert("No Payout Data"); window.history.back();</script>';                                                   
    }
} 

if($payoutmessage == 'TotalPayout'){
    $output="";
    // $stmt2 = "SELECT * FROM ca_cu_payout WHERE $designation = '".$user_id."' AND YEAR(created_date) = '".$payoutYear."' AND MONTH(created_date) = '".$payoutMonth."' ";
    $stmt2 ="SELECT 
                    ca.created_date,
                    ca.status,
                    ca.id,
                    ca.business_mentor,
                    ca.message_bm,
                    ca.commision_bm,
                    ca.status_bm,
                    ca.techno_enterprise,
                    ca.message_te,
                    ca.commision_te,
                    ca.status_te,
                    ca.travel_consultant,
                    ca.message_tc,
                    ca.commision_tc,
                    ca.status_tc,
                    COALESCE(cap.status, 0) AS status,
                    cap.date AS paydate
                FROM ca_cu_payout ca
                LEFT JOIN ca_cu_payout_paid cap 
                    ON cap.$designation = ca.$designation
                    AND cap.travel_consultant = ca.travel_consultant
                    AND YEAR(cap.date) = '".$payoutYear."'
                    AND MONTH(cap.date) = '".$payoutMonth."'
                WHERE ca.$designation = '".$user_id."' 
                AND YEAR(ca.created_date) = '".$payoutYear."' 
                AND MONTH(ca.created_date) = '".$payoutMonth."'";
    $stmt2 = $conn -> prepare($stmt2);
    $stmt2 -> execute();
    $stmt2 ->setFetchMode(PDO::FETCH_ASSOC);
    if($stmt2 -> rowCount()>0){
    	$output .= '<h2 style="text-align:center">Total Payout List as of '.$monthName.','.$payoutYear.'</h2>
        <table border="1" style="text-align:center">
            <tr>
                <th >Date</th>';
                
                if($user_id_str == "BM"){
                    $output .= '<th class="mobile_view">Business Mentor</th>
                    <th class="mobile_view">Business Mentor Name</th>';
                }else if($user_id_str == "TE" || $$user_id_str == "CA"){
                    $output .= '<th class="mobile_view">Techno Enterprise</th>
                    <th class="mobile_view">Techno Enterprise Name</th>';
                }else if($user_id_str == "SF"){
                    $output .= '<th class="mobile_view">Sponsor Franchisee</th>
                    <th class="mobile_view">Sponsor Franchisee Name</th>';
                }else if($user_id_str == "MF"){
                    $output .= '<th class="mobile_view">Master Franchisee</th>
                    <th class="mobile_view">Master Franchisee Name</th>';
                }else if($user_id_str == "F"){
                    $output .= '<th class="mobile_view">Franchisee</th>
                    <th class="mobile_view">Franchisee Name</th>';
                }else if($user_id_str == "TA"){
                    $output .= '<th class="mobile_view">Travel Agency</th>
                    <th class="mobile_view">Travel Agency Name</th>';
                }

                $output .= '<th ><span class="long-name">Payout Details</th>
                <th class="mobile_view tab_view">Amount</th>
                <th class="mobile_view" >TDS</th>
                <th style="text-align:center;">Total Payable</th>
                <th style="text-align:center;">Status</th>
                <th style="text-align:center;">Paid Date</th>
            </tr>';
            foreach($stmt2->fetchAll() as $key => $row2){
                $rd= new DateTime($row2['created_date']);
                $newDate= $rd->format('d-m-Y');
                $id = $row2['id'];

                if($user_id_str == "BM" || $user_id_str == "SF" || $user_id_str == "MF"){

                    $BC_Commi = $row2['commision_bm'];
                
                    (int)$BC_Commi_TDS = (int)$BC_Commi*2/100;
                    (int)$BC_Commi_Total = (int)$BC_Commi-(int)$BC_Commi_TDS; 

                    // date in proper formate
                    $dt = new DateTime($row2['created_date']);
                    $dt = $dt->format('Y-m-d');

                    // replace dot at end of the line with break statement
                    $message1 = $row2['message_bm'];
                    $message1 =  str_replace('.','<br>',$message1); 
                    
                    if($user_id_str == "SF"){
                        $sql1= $conn->prepare("SELECT firstname,lastname FROM `sponsor_franchisee` where sponsor_franchisee_id='".$row2['business_mentor']."'");
                    }else if($user_id_str == "MF"){
                        $sql1= $conn->prepare("SELECT firstname,lastname FROM `master_franchisee` where master_franchisee_id='".$row2['business_mentor']."'");
                    }else{
                        $sql1= $conn->prepare("SELECT firstname,lastname FROM `business_mentor` where business_mentor_id='".$row2['business_mentor']."'");
                    }
                    $sql1->execute();
                    $sql1->setFetchMode(PDO::FETCH_ASSOC);
                    if($sql1->rowCount()>0){
                        foreach (($sql1->fetchAll()) as $key => $row1) {
                            $ta_name = $row1['firstname']. ' ' .$row1['lastname'];
                        }
                    } 

                    $output .= '<tr>
                        <td >'.$newDate.'</td>
                        <td>'.$row2['business_mentor'].'</td>
                        <td>'.$ta_name.'</td>
                        <td class="message">'.$message1.'</td>
                        <td style="text-align:center;">'.$BC_Commi.'</td>
                        <td style="text-align:center;">'.$BC_Commi_TDS.'/-</td>
                        <td style="text-align:center;">'.$BC_Commi_Total.'/-</td>';
                        if($row2['status_bm'] == 2){
                            $output .='<td style="text-align:center;">Pending</td>
                                       <td style="text-align:center;">NA</td>';
                        }else if($row2['status_bm'] == 1){
                            $output .='<td style="text-align:center;">Paid</td>
                                       <td style="text-align:center;">'.$row2["paydate"].'</td>';
                        }
                    $output .='</tr>';
                }elseif($user_id_str == "TE" || $user_id_str == "CA"|| $user_id_str == "F"){

                    $CA_Commi = $row2['commision_te'];

                    (int)$CA_Commi_TDS = (int)$CA_Commi*2/100;
                    (int)$CA_Commi_Total = (int)$CA_Commi-(int)$CA_Commi_TDS; 

                    $message2 = $row2['message_te'];
                    $message2 =  str_replace('.','<br>',$message2); 

                    if($user_id_str == "TE" || $user_id_str == "CA"){
                        $sql2= $conn->prepare("SELECT firstname,lastname FROM `corporate_agency` where corporate_agency_id='".$row2['techno_enterprise']."'");
                    }else if($user_id_str == "F"){
                        $sql2= $conn->prepare("SELECT firstname,lastname FROM `sub_franchisee` where sub_franchisee_id='".$row2['techno_enterprise']."'");
                    }
                    $sql2->execute();
                    $sql2->setFetchMode(PDO::FETCH_ASSOC);
                    if($sql2->rowCount()>0){
                        foreach (($sql2->fetchAll()) as $key => $row3) {
                            $ca_name = $row3['firstname']. ' ' .$row3['lastname'];
                        }
                    } 
                    
                    $output .='<tr>
                        <td >'.$newDate.'</td>
                        <td>'.$row2['techno_enterprise'].'</td>
                        <td>'.$ca_name.'</td>
                        <td >'.$message2.'</td>
                        <td style="text-align:center;">'.$CA_Commi.'</td>
                        <td style="text-align:center;">'.$CA_Commi_TDS.'/-</td>
                        <td style="text-align:center;">'.$CA_Commi_Total.'/-</td>';
                        if($row2['status_te'] == 2){
                            $output .= '<td style="text-align:center;">Pending</td>
                                        <td style="text-align:center;">NA</td>';
                        }else if($row2['status_te'] == 1){
                            $output .= '<td style="text-align:center;">Paid</td>
                                        <td style="text-align:center;">'.$row2["paydate"].'</td>';
                        }
                    $output .='</tr>';
                }elseif($user_id_str == "TA"){

                    $CA_Commi = $row2['commision_tc'];

                    (int)$CA_Commi_TDS = (int)$CA_Commi*2/100;
                    (int)$CA_Commi_Total = (int)$CA_Commi-(int)$CA_Commi_TDS; 

                    $message2 = $row2['message_tc'];
                    $message2 =  str_replace('.','<br>',$message2); 

                    if($user_id_str == "TE" || $user_id_str == "CA"){
                        $sql2= $conn->prepare("SELECT firstname,lastname FROM `ca_travelagency` where ca_travelagency_id='".$row2['travel_consultant']."'");
                    }
                    $sql2->execute();
                    $sql2->setFetchMode(PDO::FETCH_ASSOC);
                    if($sql2->rowCount()>0){
                        foreach (($sql2->fetchAll()) as $key => $row3) {
                            $ca_name = $row3['firstname']. ' ' .$row3['lastname'];
                        }
                    } 
                    
                    $output .='<tr>
                        <td >'.$newDate.'</td>
                        <td>'.$row2['travel_consultant'].'</td>
                        <td>'.$ca_name.'</td>
                        <td >'.$message2.'</td>
                        <td style="text-align:center;">'.$CA_Commi.'</td>
                        <td style="text-align:center;">'.$CA_Commi_TDS.'/-</td>
                        <td style="text-align:center;">'.$CA_Commi_Total.'/-</td>';
                        if($row2['status_tc'] == 2){
                            $output .= '<td style="text-align:center;">Pending</td>
                                        <td style="text-align:center;">NA</td>';
                        }else if($row2['status_tc'] == 1){
                            $output .= '<td style="text-align:center;">Paid</td>
                                        <td style="text-align:center;">'.$row2["paydate"].'</td>';
                        }
                    $output .='</tr>';
                }
            }
        $output .= '</table>';
        header("Content-Type: application/xls");
        header("Content-Disposition: attachment;filename=Total_Payout_List.xls");
        echo $output;
    }else{
        echo '<script>alert("No Payout Data"); window.history.back();</script>';                                                
    }
}
//not in use 
if($payoutmessage == 'allPayout'){
    // if($user_id_str == 'BM' || $user_id_str == 'SF' || $user_id_str == 'MF'){
    //     $stmt2 = " SELECT * FROM ca_cu_payout WHERE business_mentor = '".$user_id."' AND YEAR(created_date) = '".$payoutYear."' AND MONTH(created_date) = '".$payoutMonth."' ";
    // }else if($user_id_str == 'TE' || $user_id_str == 'CA' || $user_id_str == 'F'){
    //     $stmt2 = " SELECT * FROM ca_cu_payout WHERE techno_enterprise = '".$user_id."' AND YEAR(created_date) = '".$payoutYear."' AND MONTH(created_date) = '".$payoutMonth."' ";
    // }
    $stmt2 = " SELECT 
                    ca.created_date,
                    ca.status,
                    ca.id,
                    ca.business_mentor,
                    ca.message_bm,
                    ca.commision_bm,
                    ca.status_bm,
                    ca.techno_enterprise,
                    ca.message_te,
                    ca.commision_te,
                    ca.status_te,
                    ca.travel_consultant,
                    ca.message_tc,
                    ca.commision_tc,
                    ca.status_tc,
                    COALESCE(cap.status, 0) AS status,
                    cap.date AS paydate
                FROM ca_cu_payout ca
                LEFT JOIN ca_cu_payout_paid cap 
                    ON cap.$designation = ca.$designation
                    AND cap.techno_enterprise = ca.techno_enterprise
                    AND YEAR(cap.date) = '".$payoutYear."'
                    AND MONTH(cap.date) = '".$payoutMonth."'
                WHERE ca.$designation = '".$user_id."' 
                AND YEAR(ca.created_date) = '".$payoutYear."' 
                AND MONTH(ca.created_date) = '".$payoutMonth."'";
    
    $output="";
    $stmt2 = $conn -> prepare($stmt2);
    $stmt2 -> execute();
    $stmt2 ->setFetchMode(PDO::FETCH_ASSOC);
    if($stmt2 -> rowCount()>0){
    	$output .= '<h2 style="text-align:center">All Payout List as of '.$monthName.','.$payoutYear.'</h2>
        <table border="1" style="text-align:center">
            <tr>
                <th >Date</th>';
                if ($user_id_str == 'BM'|| $user_id_str == 'TE' || $user_id_str == 'CA') {
                    $output.='<th class="mobile_view">Business Consultant</th>
                    <th class="mobile_view">Business Consultant Name</th>
                    <th class="mobile_view">Corporate Agency</th>
                    <th class="mobile_view">Corporate Agency Name</th>';
                }else if($user_id_str == 'F'|| $user_id_str == 'SF' || $user_id_str == 'MF'){
                    $output.='<th class="mobile_view">Ref Id</th>
                    <th class="mobile_view">Ref Name</th>
                    <th class="mobile_view">Franchisee</th>
                    <th class="mobile_view">Franchisee Name</th>';
                }

                $output.='<th ><span class="long-name">Payout Details</th>
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
                $BC_Commi = $row2['commision_bm'];
                $CA_Commi = $row2['commision_te'];
                $ca_ta_Commi = $row2['ca_ta_amt_paid'];
               
                (int)$BC_Commi_TDS = (int)$BC_Commi*5/100;
                (int)$BC_Commi_Total = (int)$BC_Commi-(int)$BC_Commi_TDS; 

                (int)$CA_Commi_TDS = (int)$CA_Commi*5/100;
                (int)$CA_Commi_Total = (int)$CA_Commi-(int)$CA_Commi_TDS; 

                (int)$ca_ta_Commi_TDS = (int)$ca_ta_Commi*5/100;
                (int)$ca_ta_Commi_Total = (int)$ca_ta_Commi-(int)$ca_ta_Commi_TDS; 

                // date in proper formate
                $dt = new DateTime($row2['created_date']);
                $dt = $dt->format('Y-m-d');

                // replace dot at end of the line with break statement
                $message1 = $row2['message_bm'];
                $message1 =  str_replace('.','<br>',$message1); 
                $message2 = $row2['message_te'];
                $message2 =  str_replace('.','<br>',$message2); 
                $message3 = $row2['message_ca_ta'];
                $message3 =  str_replace('.','<br>',$message3); 
                
                if($user_id_str == "SF"){
                    $sql1= $conn->prepare("SELECT firstname,lastname FROM `sponsor_franchisee` where sponsor_franchisee_id='".$row2['business_mentor']."'");
                }else if($user_id_str == "MF"){
                    $sql1= $conn->prepare("SELECT firstname,lastname FROM `master_franchisee` where master_franchisee_id='".$row2['business_mentor']."'");
                }else{
                    $sql1= $conn->prepare("SELECT firstname,lastname FROM `business_mentor` where business_mentor_id='".$row2['business_mentor']."'");
                }
                $sql1->execute();
                $sql1->setFetchMode(PDO::FETCH_ASSOC);
                if($sql1->rowCount()>0){
                    foreach (($sql1->fetchAll()) as $key => $row1) {
                        $ta_name = $row1['firstname']. ' ' .$row1['lastname'];
                    }
                } 

                if($user_id_str == "TE" || $user_id_str == "CA"){
                    $sql2= $conn->prepare("SELECT firstname,lastname FROM `corporate_agency` where corporate_agency_id='".$row2['techno_enterprise']."'");
                }else if($user_id_str == "F"){
                    $sql2= $conn->prepare("SELECT firstname,lastname FROM `sub_franchisee` where sub_franchisee_id='".$row2['techno_enterprise']."'");
                }
                $sql2->execute();
                $sql2->setFetchMode(PDO::FETCH_ASSOC);
                if($sql2->rowCount()>0){
                    foreach (($sql2->fetchAll()) as $key => $row3) {
                        $ca_name = $row3['firstname']. ' ' .$row3['lastname'];
                    }
                } 

                $output .= '<tr>
                    <td >'.$newDate.'</td>
                    <td>'.$row2['business_mentor'].'</td>
                    <td>'.$ta_name.'</td>
                    <td>'.$row2['techno_enterprise'].'</td>
                    <td>'.$ca_name.'</td>
                    <td class="message">'.$message1.'</td>
                    <td style="text-align:center;">'.$BC_Commi.'</td>
                    <td style="text-align:center;">'.$BC_Commi_TDS.'/-</td>
                    <td style="text-align:center;">'.$BC_Commi_Total.'/-</td>';
                    if($row2['status_bm'] == 0){
                        $output .='<td style="text-align:center;">Pending</td>';
                    }else{
                        $output .='<td style="text-align:center;">Paid</td>';
                    }
                $output .='</tr>';
                
                
                $output .='<tr>
                    <td >'.$newDate.'</td>
                    <td>'.$row2['business_mentor'].'</td>
                    <td>'.$ta_name.'</td>
                    <td>'.$row2['techno_enterprise'].'</td>
                    <td>'.$ca_name.'</td>
                    <td >'.$message2.'</td>
                    <td style="text-align:center;">'.$CA_Commi.'</td>
                    <td style="text-align:center;">'.$CA_Commi_TDS.'/-</td>
                    <td style="text-align:center;">'.$CA_Commi_Total.'/-</td>';
                    if($row2['status_te'] == 0){
                        $output .= '<td style="text-align:center;">Pending</td>';
                    }else{
                        $output .= '<td style="text-align:center;">Paid</td>';
                    }
                $output .='</tr>';
                
                // if($message3){
                //     $output .= '<tr>
                //         <td >'.$newDate.'</td>
                //         <td>'.$row2['business_consultant'].'</td>
                //         <td>'.$ta_name.'</td>
                //         <td>'.$row2['corporate_agency'].'</td>
                //         <td>'.$ca_name.'</td>
                //         <td >'.$message3.'</td>
                //         <td style="text-align:center;">'.$ca_ta_Commi.'</td>
                //         <td style="text-align:center;"> '.$ca_ta_Commi_TDS.'/-</td>
                //         <td style="text-align:center;"> '.$ca_ta_Commi_Total.'/-</td>';
                //         if($row2['status_ca_ta'] == 0){
                //             $output .='<td style="text-align:center;">Pending</td>';
                //         }else{
                //             $output .= '<td style="text-align:center;">Paid</td>';
                //         }
                //     $output .='</tr>';
                // }
               
            }
        $output .= '</table>';
        header("Content-Type: application/xls");
        header("Content-Disposition: attachment;filename=All_Payout_List.xls");
        echo $output;
    }else{
        echo '<script>alert("No Payout Data"); window.history.back();</script>';                                                   
    }
}

    
?>